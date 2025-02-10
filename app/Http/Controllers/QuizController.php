<?php

namespace App\Http\Controllers;

use App\Jobs\CalculateAudienceQuizScore;
use App\Models\AudienceQuiz;
use App\Models\Quiz;
use Arr;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        request()->validate([
            'tag' => ['required']
        ]);

        $tag = request()->tag;

        $query = Quiz::where('tag', $tag)->where('status', 'published')->simplePaginate(50);
        $audienceQuizzes = AudienceQuiz::whereIn('quiz.id', $query->pluck('id'))->select('result', 'quiz')->whereNotNull('result.started_at')->pluck('result', 'quiz.id');

        $query->map(function ($q) use ($audienceQuizzes) {
            $q['result'] = $audienceQuizzes[$q->id] ?? null;
            return $q;
        });

        return responder()->success($query);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Quiz $quiz)
    {
        $audienceId = auth()->user()->audience->id;
        $search = AudienceQuiz::where(['quiz.id' => $quiz->id, 'audience_id' => $audienceId])->first();

        if (! $search && $quiz->questions()->exists() && $quiz->status === 'published') {
            $questionId = 0;
            
            $questions = $quiz->questions()
                ->inRandomOrder()
                ->limit($quiz->total_questions)
                ->get()
                ->map(function ($question) use (&$questionId) {
                    $data = [
                        'id'             => $questionId++,
                        'question'       => $question->question,
                        'single_choice'  => count(array_filter($question->answers, fn ($answer) => $answer['correct'])) === 1,
                        'correct_weight' => $question->correct_weight,
                        'wrong_weight'   => $question->wrong_weight,
                        'selected'       => null
                    ];

                    $answerId = 0;

                    $answers = array_map(function ($answer) use (&$answerId) {
                        $answer['id'] = $answerId++;
                        return $answer;
                    }, $question->answers);

                    shuffle($answers);

                    return [
                        ...$data,
                        'answers' => $answers
                    ];
                })
                ->toArray();

            shuffle($questions);

            $search = AudienceQuiz::create([
                'quiz'            => $quiz->toArray(),
                'audience_id'     => $audienceId,
                'total_questions' => count($questions),
                'questions'       => $questions,
                'result'          => [
                    'correct_answers' => null,
                    'wrong_answers'   => null,
                    'not_answered'    => null,
                    'score'           => null,
                    'started_at'      => null,
                    'ended_at'        => null,
                ]
            ]);
        }
        
        return $search ? responder()->success($search) : responder()->error(404, "Not found")->respond(404);
    }


    public function start(AudienceQuiz $audienceQuiz)
    {
        if (!empty($audienceQuiz->result['ended_at'])) {
            return responder()->error(403, "The quiz been ended")->respond(403);
        }

        if (empty($audienceQuiz->result['started_at'])) {
            $audienceQuiz->update([
                '$set' => [
                    'result.started_at' => now()
                ]
            ]);
        }

        return responder()->success(['message' => 'Quiz has been started']);
    }

    public function end(AudienceQuiz $audienceQuiz)
    {
        if (empty($audienceQuiz->result['ended_at'])) {
            $audienceQuiz->update([
                '$set' => [
                    'result.ended_at' => now()
                ]
            ]);

        }
        dispatch(new CalculateAudienceQuizScore($audienceQuiz));

        return responder()->success(['message' => 'Quiz has been ended']);
    }

    public function answer(AudienceQuiz $audienceQuiz, Request $request)
    {
        $request->validate([
            'question_id' => ['required'],
            'answer_ids'  => ['required', 'array'],
            'answer_ids.*'=> ['numeric'],
        ]);

        $audienceQuiz->update([
            '$set' => [
                "questions.{$request->question_id}.selected" => count($request->answer_ids) === 0 ? null : array_map(fn ($id) => (int) $id, $request->answer_ids),
            ]
        ]);

        return responder()->success(['message' => 'Question has been answered']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quiz $quiz)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quiz)
    {
        //
    }
}
