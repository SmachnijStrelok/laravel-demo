<?php

namespace App\Http\Services\Sender\EmailLetters;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailUpdateEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $activationCode;
    private $toEmails;

    public function __construct($to, string $activationCode)
    {
        $this->activationCode = $activationCode;
        $this->toEmails = $to;
    }

    /**
     * @return EmailUpdateEmail
     */
    public function build()
    {
        return $this
            ->to($this->toEmails)
            ->view('mail.email_update')
            ->with(
                [
                    'activation_code' => $this->activationCode
                ]);
    }
}
