<?php

namespace App\Http\Services\Sender\EmailLetters;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserCreateEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $toEmails;
    private $loginLink;
    private $password;

    public function __construct($to, $loginLink, $password)
    {

        $this->toEmails = $to;
        $this->loginLink = $loginLink;
        $this->password = $password;
    }

    public function build()
    {
        return $this
            ->to($this->toEmails)
            ->view('mail.user_create')
            ->with(
                [
                    'login_link' => $this->loginLink,
                    'password' => $this->password
                ]);
    }
}
