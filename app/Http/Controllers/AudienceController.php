<?php

namespace App\Http\Controllers;

use App\Http\Requests\AudienceRegisterRequest;
use App\Mail\AudienceUserCreated;
use App\Models\Audience;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Log;

class AudienceController extends Controller
{
    public function register(AudienceRegisterRequest $request)
    {
        $user = User::firstOrCreate([
            'email' => $request->email,
        ], [
            'name' => $request->name,
            'password' => bcrypt($request->password)
        ]);

        Mail::to('agnbhr@pm.me')->queue(new AudienceUserCreated($user, $request->password));

        Audience::updateOrCreate([
            'user_id' => $user->id
        ], $request->only('name', 'gender', 'birthday', 'phone', 'location'));

        return responder()->success(['message' => 'audience has been registered']);
    }
    
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'string', 'max:100', Rule::unique('users')->ignore($user->id)],
            'gender'   => ['required', 'in:male,female'],
            'birthday' => ['required', 'date'],
            'password' => ['nullable', 'size:6'],
            'phone'    => ['required', 'string', 'max:14', 'min:9']
        ]);

        if ($request->password) {
            $user->update(['password' => bcrypt($request->password)]);
        }

        if ($request->email) {
            $user->update(['email' => $request->email]);
        }

        if ($request->name) {
            $user->update(['name' => $request->name]);
        }

        Audience::find($user->audience->id)->update($request->only('name', 'gender', 'birthday', 'phone', 'location'));

        return responder()->success(['name' => $user->name]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($request->only('email', 'password'))) {
            return responder()->success(401, 'unauthenticated')->respond(401);
        }

        $token = auth()->user()->createToken('QTDB')->accessToken;

        return responder()->success(['token' => $token, 'name' => auth()->user()->name]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return responder()->success(['message' => 'User has signed out']);
    }

    public function checkEmail(Request $request)
    {
        if (User::where('email', $request->email)->exists()) {
            return responder()->error(442, 'Email has not been registered')->respond(442);
        }

        return responder()->success(['message' => 'Email has not been registered']);
    }

    public function profile()
    {
        $auth = auth()->user();
        $user = [...$auth->audience->toArray(), 'email' => $auth->email];
        return responder()->success($user);
    }
}
