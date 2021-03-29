<?php
namespace App\Http\Components\User\Email\UseCase;

use App\Http\Components\User\Entities\User;
use App\Http\Components\User\Entities\UserConfirmation;
use App\Http\Components\User\Repositories\Contracts\IUserConfirmationRepository;
use App\Http\Components\User\Repositories\Contracts\IUserRepository;
use App\Http\Components\User\SignUp\Validators\EmailValidator;
use App\Http\Services\Sender\EmailLetters\EmailUpdateEmail;
use App\Http\Services\Sender\MailSender;

class ResetRequest
{
    private $userRepository;
    private $emailValidator;
    private $mailSender;
    private $confirmationRepository;

    public function __construct(
        IUserRepository $userRepository,
        EmailValidator $emailValidator,
        MailSender $mailSender,
        IUserConfirmationRepository $confirmationRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->emailValidator = $emailValidator;
        $this->mailSender = $mailSender;
        $this->confirmationRepository = $confirmationRepository;
    }

    public function reset(string $newEmail)
    {
        $user = $this->userRepository->me();
        $this->emailValidator->validate($newEmail);
        $this->sendConfirmation($user, $newEmail);
    }

    private function sendConfirmation(User $user, $newEmail)
    {
        $code = (string)$this->generateCode();
        $this->sendEmail($newEmail, $code);

        $this->createConfirmation($user, $newEmail, $code);
    }

    private function generateCode()
    {
        return rand(100001, 999999);
    }

    private function sendEmail(string $newEmail, string $code)
    {
        $emailLetter = new EmailUpdateEmail($newEmail, $code);
        $this->mailSender->send($emailLetter);
    }

    private function createConfirmation(User $user, string $newEmail, string $activateCode)
    {
        $confirmation = UserConfirmation::createEmailUpdateConfirmation($user->id, $newEmail, $activateCode);
        if(!$this->confirmationRepository->createAndDeactivatePrevious($confirmation, $confirmation::TYPE_EMAIL)){
            throw new \DomainException('Не удалось создать подтверждение по e-mail');
        }
    }
}