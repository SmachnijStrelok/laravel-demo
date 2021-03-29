<?php
namespace App\Http\Components\User\SignUp\Services;

use App\Http\Components\User\SignUp\Services\RequestHandlers\EmailHandler;
use App\Http\Components\User\SignUp\Services\RequestHandlers\IRequestHandler;
use App\Http\Components\User\SignUp\Services\RequestHandlers\MobilePhoneHandler;

class SignUpFactory
{
    public function makeSignUpRequestHandler(string $registrationType): IRequestHandler
    {
        if($registrationType == 'sms'){
            return resolve(MobilePhoneHandler::class);
        }else if($registrationType == 'email'){
            return resolve(EmailHandler::class);
        }else{
            throw new \DomainException('Неизвестный тип регистрации');
        }
    }
}