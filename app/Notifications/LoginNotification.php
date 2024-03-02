<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoginNotification extends Notification
{
    use Queueable;

    // AMA-notification
    public $message;
    public $subject;
    public $mailer; // from config\mail.php
    public $fromEmail;


    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        $this->message = "Welcome, you are now logged in";
        $this->subject = "New Log In";
        $this->fromEmail = "home_life_app@amasheta.com";
        $this->mailer = "smtp";
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->mailer($this->mailer)
                    ->subject($this->subject)
                    ->greeting("HELLO ". $notifiable->name)
                    ->line($this->message)
                    ->action('visite the website', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
