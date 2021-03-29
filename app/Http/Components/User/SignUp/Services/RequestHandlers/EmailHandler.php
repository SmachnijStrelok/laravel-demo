<?php
namespace App\Http\Components\User\SignUp\Services\RequestHandlers;

use App\Http\Components\User\Entities\User;
use App\Http\Components\User\Entities\UserConfirmation;
use App\Http\Components\User\Repositories\Contracts\IUserConfirmationRepository;
use App\Http\Components\User\Repositories\Contracts\IUserRepository;
use App\Http\Components\User\SignUp\Services\EmailConfirmLinkGenerator;
use App\Http\Components\User\SignUp\Validators\EmailValidator;
use App\Http\Components\User\SignUp\Validators\PhoneValidator;
use App\Http\Services\Sender\EmailLetters\SignUpEmail;
use App\Http\Services\Sender\MailSender;
use App\Http\Services\Sender\SmsSender;

class EmailHandler implements IRequestHandler
{

    private $validator;
    private $userRepository;
    private $sender;
    private $confirmation;
    private $generator;

    public function __construct(
        IUserRepository $userRepository,
        IUserConfirmationRepository $confirmation,
        EmailValidator $validator,
        MailSender $sender,
        EmailConfirmLinkGenerator $generator
    )
    {
        $this->validator = $validator;
        $this->userRepository = $userRepository;
        $this->sender = $sender;
        $this->confirmation = $confirmation;
        $this->generator = $generator;
    }

    public function register(User $user): User
    {
        $this->validator->validate($user->email);
        if(!$user = $this->userRepository->create($user)){
            throw new \DomainException('Не удалось создать пользователя');
        }

        $this->sendConfirmation($user);
        return $user;
    }

    // TODO возможно стоит вынести в отдельные классы отправку
    public function sendConfirmation(User $user, ?string $action = null)
    {
        $code = (string)$this->generateCode();
        $this->sendEmail($user, $code);

        $this->createConfirmation($user, $code, $action);
    }

    private function generateCode()
    {
        return rand(100001, 999999);
    }

    private function sendEmail(User $user, string $code)
    {
        $confirmLink = $this->generator->generateEmailLink($user->id, $code);

        $emailLetter = new SignUpEmail($user->email, $confirmLink);
        $this->sender->send($emailLetter);
    }

    private function createConfirmation(User $user, string $activateCode, ?string $action)
    {
        $action = $action ?? UserConfirmation::ACTION_SIGN_UP;
        $confirmation = new UserConfirmation();
        $confirmation->user_id = $user->id;
        $confirmation->action = $action;
        $confirmation->type = $confirmation::TYPE_EMAIL;
        $confirmation->code = $activateCode;
        $confirmation->is_active = true;

        if(!$this->confirmation->createAndDeactivatePrevious($confirmation, $confirmation::TYPE_EMAIL)){
            throw new \DomainException('Не удалось создать подтверждение по e-mail');
        }
    }
}