<?php

use App\Events\PusherEvent;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    require __DIR__ . '/auth.php';
    require __DIR__ . '/profile.php';
    require __DIR__ . '/teacher.php';
    require __DIR__ . '/course.php';
    require __DIR__ . '/exams.php';
    require __DIR__ . '/posts.php';
    require __DIR__ . '/users.php';

    require __DIR__ . '/payment.php';
    require __DIR__ . '/others.php';
});
