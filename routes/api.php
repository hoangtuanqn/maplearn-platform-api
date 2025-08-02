<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    require __DIR__ . '/auth.php';
    require __DIR__ . '/profile.php';
    require __DIR__ . '/course.php';
    require __DIR__ . '/documents.php';
    require __DIR__ . '/subjects.php';
    require __DIR__ . '/posts.php';
    require __DIR__ . '/comments.php';
    require __DIR__ . '/tags.php';
    require __DIR__ . '/users.php';
    require __DIR__ . '/chat.php';
    require __DIR__ . '/course_categories.php';
    require __DIR__ . '/audiences.php';
    require __DIR__ . '/others.php';
});
