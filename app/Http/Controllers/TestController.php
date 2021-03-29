<?php
namespace App\Http\Controllers;

use App\Http\Components\User\Repositories\Contracts\IUserRepository;
use App\Http\Services\Sender\EmailLetters\SignUpEmail;
use App\Http\Services\Sender\MailSender;
use App\Http\Services\Sender\SmsSender;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * @param Request $request
     * @param IUserRepository $userRepository
     * @param SmsSender $smsSender
     */
    public function testSms(Request $request, IUserRepository $userRepository, SmsSender $smsSender){
        if(!$userRepository->me()->isAdmin()){
            throw new \DomainException('access denied');
        }
        $phone = (int)$request->route('phone');
        $message = $request->route('message');
        $smsSender->send($phone, $message);
    }

    /**
     * @param Request $request
     * @param IUserRepository $userRepository
     * @param MailSender $mailSender
     */
    public function testEmail(Request $request, IUserRepository $userRepository, MailSender $mailSender){
        if(!$userRepository->me()->isAdmin()){
            throw new \DomainException('access denied');
        }
        $email = $request->route('email');
        $signUpEmail = new SignUpEmail($email, 'https://yandex.ru');
        $mailSender->send($signUpEmail);
    }
}
