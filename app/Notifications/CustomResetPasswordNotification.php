<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class CustomResetPasswordNotification extends ResetPassword
{
    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // The URL for the password reset link
        $resetUrl = url(config('app.url').route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        // Get the password expiration time in minutes
        $expireMinutes = config('auth.passwords.'.config('auth.defaults.passwords').'.expire');

        return (new MailMessage)
                    ->subject(Lang::get('Reset Your Password - ' . config('app.name')))
                    // Point to your new Blade view and pass data to it
                    ->markdown('emails.custom-password-reset', [
                        'user' => $notifiable,
                        'resetUrl' => $resetUrl,
                        'expireMinutes' => $expireMinutes
                    ]);
    }
}