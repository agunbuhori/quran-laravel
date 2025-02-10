<?php

use App\Jobs\EndExpiredAudienceQuiz;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schedule;

Schedule::command("telegram:refresh")->hourly();

Schedule::call(function () {
    File::put(storage_path("logs/scheduler.log"), "");
    File::put(storage_path("logs/queue.log"), "");
    File::put(storage_path("logs/laravel.log"), "");
})->dailyAt('01:00');

Schedule::job(new EndExpiredAudienceQuiz())->everyMinute();