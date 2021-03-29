<?php

namespace App\Http\Services\Sender;

use App\Http\Components\Settings\Setting;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class MailSender
{
    // для извлечения из бд настроек и переопределения значинй конфига
    //public function __construct(Setting $setting)
    public function __construct()
    {
    }

    public function send(Mailable $email)
    {
        Mail::send($email);
    }
}
