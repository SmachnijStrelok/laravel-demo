<?php

namespace App\Http\Services\Sender\EmailLetters;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SignUpEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $activationLink;
    private $toEmails;

    public function __construct($to, string $activationLink)
    {
        $this->activationLink = $activationLink;
        $this->toEmails = $to;
    }

    public function build()
    {
        return $this
            ->to($this->toEmails)
            ->view('mail.sign_up')
            ->with(
                [
                    'activation_link' => $this->activationLink
                ]);
    }
}
