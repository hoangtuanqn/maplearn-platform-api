<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailNotification extends Notification
{
    public $token; // <-- BẠN PHẢI CÓ DÒNG NÀY

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Xác minh tài khoản')
            ->greeting('Chào ' . $notifiable->full_name)
            ->line('Vui lòng nhấn vào nút bên dưới để xác minh email của bạn.')
            ->action('Xác minh tài khoản',  env('APP_URL_FRONT_END', 'http://localhost:3000') . '/auth/verify/' . $this->token) // <-- dùng $this->token
            ->line('Nếu bạn không đăng ký tài khoản, vui lòng bỏ qua email này.');
    }
}
