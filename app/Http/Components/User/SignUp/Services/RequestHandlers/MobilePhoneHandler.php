<?php
namespace App\Http\Components\User\SignUp\Services\RequestHandlers;

use App\Http\Components\User\Entities\User;
use App\Http\Components\User\Entities\UserConfirmation;
use App\Http\Components\User\Repositories\Contracts\IUserConfirmationRepository;
use App\Http\Components\User\Repositories\Contracts\IUserRepository;
use App\Http\Components\User\SignUp\Validators\PhoneValidator;
use App\Http\Services\Sender\SmsSender;

class MobilePhoneHandler implements IRequestHandler
{

    private $validator;
    private $user;
    private $sender;
    private $confirmation;

    public function __construct(
        IUserRepository $user,
        IUserConfirmationRepository $confirmation,
        PhoneValidator $validator,
        SmsSender $sender
    )
    {
        $this->validator = $validator;
        $this->user = $user;
        $this->sender = $sender;
        $this->confirmation = $confirmation;
    }

    public function register(User $user): User
    {
        $this->validator->validate($user->mobile_phone);
        if(!$user = $this->user->create($user)){
            throw new \DomainException('Не удалось создать пользователя');
        }

        $this->sendConfirmation($user);
        return $user;
    }

    public function sendConfirmation(User $user, ?string $action = null)
    {
        $code = (string)$this->generateCode();
        $this->createConfirmation($user, $code, $action);
        //$this->sender->send($user->mobile_phone, $code);
    }

    private function generateCode()
    {
        return rand(100001, 999999);
    }

    private function createConfirmation(User $user, string $activateCode, ?string $action)
    {
        $action = $action ?? UserConfirmation::ACTION_SIGN_UP;
        $confirmation = new UserConfirmation();
        $confirmation->user_id = $user->id;
        $confirmation->action = $action;
        $confirmation->type = $confirmation::TYPE_SMS;
        $confirmation->code = $activateCode;
        $confirmation->is_active = true;

        if(!$this->confirmation->createAndDeactivatePrevious($confirmation, $confirmation::TYPE_SMS)){
            throw new \DomainException('Не удалось создать подтверждение по смс');
        }
    }
}
