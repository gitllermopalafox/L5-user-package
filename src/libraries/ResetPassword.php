<?php

namespace SidneyDobber\User;

use Illuminate\Auth\Passwords\TokenRepositoryInterface;
use Illuminate\Contracts\Mail\Mailer as MailerContract;
use Illuminate\Contracts\Auth\PasswordBroker as PasswordBrokerContract;

class ResetPassword {

    public function __construct(
        TokenRepositoryInterface $tokens,
        MailerContract $mailer
    ) {
        $this->mailer = $mailer;
        $this->tokens = $tokens;
    }


    public function sendResetMail ($view, $user, $from, $subject) {
        // If no user was found return with a message.
        if (is_null($user)) {
            return PasswordBrokerContract::INVALID_USER;
        }
        // Generate a reset token for the user.
        $token = $this->tokens->create($user);
        // Send the reset email.
        $response = $this->emailResetLink($view, $user, $token, $from,  $subject);
        // Return based on the response.
        if($response == 1) {
            return PasswordBrokerContract::RESET_LINK_SENT;
        }
    }


    private function emailResetLink($view, $user, $token, $from, $subject) {
        // Return the response of the send request.
        return $this->mailer->send($view, compact('token', 'user'), function ($m) use ($user, $token, $from, $subject) {
            $m->to($user->getEmailForPasswordReset());
            $m->from($from);
            $m->subject($subject);
        });
    }

}
