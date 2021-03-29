<?php
namespace App\Http\Services\Sender\EmailLetters;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRequestEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $toEmails;
    private $fullName;
    private $phone;
    private $message;

    public function __construct($to, $fullName, $phone, $message)
    {

        $this->toEmails = $to;
        $this->fullName = $fullName;
        $this->phone = $phone;
        $this->message = $message;
    }

    public function build()
    {
        return $this
            ->to($this->toEmails)
            ->subject('Новая заявка')
            ->view('mail.user_request')
            ->with(
                [
                    'full_name' => $this->fullName,
                    'phone' => $this->phone,
                    'text' => $this->message
                ]);
    }
}
