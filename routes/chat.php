<?php
// Chat Bot AI

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;

Route::post('/chat-bot-ai', [ChatController::class, 'chat']);
