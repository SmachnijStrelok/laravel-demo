<?php
namespace App\Http\Components\User\MobilePhone\UseCase;

use App\Http\Components\User\Entities\User;
use App\Http\Components\User\Entities\UserConfirmation;
use App\Http\Components\User\Repositories\Contracts\IUserConfirmationRepository;
use App\Http\Components\User\Repositories\Contracts\IUserRepository;
use App\Http\Components\User\SignUp\Validators\EmailValidator;
use App\Http\Components\User\SignUp\Validators\PhoneValidator;
use App\Http\Services\Sender\EmailLetters\EmailUpdateEmail;
use App\Http\Services\Sender\MailSender;
use App\Http\Services\Sender\SmsSender;

class ResetRequest
{
    private $userRepository;
    private $phoneValidator;
    private $smsSender;
    private $confirmationRepository;

    public function __construct(
        IUserRepository $userRepository,
        PhoneValidator $phoneValidator,
        SmsSender $smsSender,
        IUserConfirmationRepository $confirmationRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->phoneValidator = $phoneValidator;
        $this->smsSender = $smsSender;
        $this->confirmationRepository = $confirmationRepository;
    }

    public function reset(int $newPhone)
    {
        $user = $this->userRepository->me();
        $this->phoneValidator->validate($newPhone);
        $this->sendConfirmation($user, $newPhone);
    }

    private function sendConfirmation(User $user, $newPhone)
    {
        $code = (string)$this->generateCode();
        $this->sendSms($newPhone, $code);

        $this->createConfirmation($user, $newPhone, $code);
    }

    private function generateCode()
    {
        return rand(100001, 999999);
    }

    private function sendSms(string $newPhone, string $code)
    {
        $this->smsSender->send($newPhone, $code);
    }

    private function createConfirmation(User $user, string $newPhone, string $activateCode)
    {
        $confirmation = UserConfirmation::createMobilePhoneUpdateConfirmation($user->id, $newPhone, $activateCode);
        if(!$this->confirmationRepository->createAndDeactivatePrevious($confirmation, $confirmation::TYPE_SMS)){
            throw new \DomainException('Не удалось создать подтверждение по СМС');
        }
    }
}