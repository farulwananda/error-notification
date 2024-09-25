<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class ErrorNotification extends Notification
{
    /**
     * Create a new notification instance.
     */
    public function __construct(public \Throwable $exception)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['telegram'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toTelegram(object $notifiable): TelegramMessage
    {
        $exception = $this->exception->getMessage();
        $file = $this->exception->getFile();
        $line = $this->exception->getLine();
        $userAgent = request()->userAgent();
        $url = request()->fullUrl();
        $ip = request()->ip();

        return TelegramMessage::create()
            ->content('Error Notification ')
            ->line("Exception: *{$exception}*")
            ->line("File: {$file}")
            ->line("Line: {$line}")
            ->line("User Agent: {$userAgent}")
            ->line("URL: {$url}")
            ->line("IP Address: {$ip}");
    }
}
