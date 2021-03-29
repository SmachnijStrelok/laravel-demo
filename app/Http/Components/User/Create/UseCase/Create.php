<?php
namespace App\Http\Components\User\Create\UseCase;

use App\Http\Components\User\Entities\User;
use App\Http\Components\User\Entities\UserConfirmation;
use App\Http\Components\User\Repositories\Contracts\IUserConfirmationRepository;
use App\Http\Components\User\Repositories\Contracts\IUserRepository;
use App\Http\Components\User\SignUp\Services\PasswordHasher;
use App\Http\Components\User\SignUp\Validators\EmailValidator;
use App\Http\Components\User\SignUp\Validators\PhoneValidator;
use App\Http\Services\Sender\EmailLetters\UserCreateEmail;
use App\Http\Services\Sender\MailSender;
use App\Http\Services\Sender\SmsSender;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class Create
{
    private IUserRepository $userRepository;
    private IUserConfirmationRepository $confirmationRepository;
    private PasswordHasher $hasher;
    private EmailValidator $emailValidator;
    private PhoneValidator $phoneValidator;
    private MailSender $mailSender;
    private SmsSender $smsSender;

    public function __construct(
        IUserRepository $userRepository,
        IUserConfirmationRepository $confirmationRepository,
        PasswordHasher $hasher,
        EmailValidator $emailValidator,
        PhoneValidator $phoneValidator,
        MailSender $mailSender,
        SmsSender $smsSender
    )
    {
        $this->userRepository = $userRepository;
        $this->confirmationRepository = $confirmationRepository;
        $this->hasher = $hasher;
        $this->emailValidator = $emailValidator;
        $this->phoneValidator = $phoneValidator;
        $this->mailSender = $mailSender;
        $this->smsSender = $smsSender;
    }

    /**
     * @param User $user
     * @param string $registerType
     * @return User|null
     * @throws \Exception
     */
    public function create(User $user, string $registerType)
    {
        if(!Auth::user()->isAdmin()){
            throw new AccessDeniedException('access denied');
        }

        DB::beginTransaction();
        try{
            $password = $user->password_hash;
            $user = $this->fillDefaultAttributes($user);
            $this->validate($user);
            $user->password_hash = $this->hasher->hash($user->password_hash);
            $user = $this->saveUser($user);
            $this->createConfirmation($user, $registerType);
            //$this->sendPasswordToUser($user, $password, $registerType);
        } catch (\Exception $exception){
            DB::rollBack();
            throw $exception;
        }
        DB::commit();
        return $this->userRepository->getById($user->id);

    }

    /**
     * @param User $user
     * @return User
     */
    private function fillDefaultAttributes(User $user)
    {
        $user->state = $user::STATE_ACTIVE;
        $user->role = $user::ROLE_USER;
        return $user;
    }

    /**
     * @param User $user
     */
    private function validate(User $user)
    {
        if(!$user->email && !$user->mobile_phone){
            throw new \DomainException('Должен быть введен телефон или e-mail');
        }

        if($user->email){
            $this->emailValidator->validate($user->email);
        }

        if($user->mobile_phone){
            $this->phoneValidator->validate($user->mobile_phone);
        }
    }

    /**
     * @param User $user
     * @return User
     */
    private function saveUser(User $user)
    {
        return $this->userRepository->save($user);
    }

    /**
     * @param User $user
     * @param string $type
     */
    private function createConfirmation(User $user, string $type)
    {
        $confirmation = new UserConfirmation();
        $confirmation->user_id = $user->id;
        $confirmation->action = $confirmation::ACTION_SIGN_UP;
        $confirmation->type = $type;
        $confirmation->code = null;
        $confirmation->is_active = false;
        $this->confirmationRepository->createAndDeactivatePrevious($confirmation, $confirmation::TYPE_SMS);
    }

    /**
     * @param User $user
     * @param string $password
     * @param string $registerType
     */
    private function sendPasswordToUser(User $user, string $password, string $registerType)
    {
        if($registerType == 'sms'){
            $this->sendSms($user->mobile_phone, $password);
        }else if($registerType == 'email'){
            $this->sendEmail($user->email, $password);
        }else{
            throw new \DomainException('Неизвестный тип регистрации');
        }
    }

    /**
     * @param string $email
     * @param string $password
     */
    private function sendEmail(string $email, string $password)
    {
        $loginLink = env('APP_LOGIN_LINK');
        $emailLetter = new UserCreateEmail($email, $loginLink, $password);
        $this->mailSender->send($emailLetter);
    }

    /**
     * @param string $phone
     * @param string $password
     */
    private function sendSms(string $phone, string $password)
    {
        $appUrl = env('APP_URL');
        $message = 'Добро пожаловать на '.$appUrl.'\n'.
            'логин: '.$phone.'\n'.
            'пароль: '.$password;
        $this->smsSender->send($phone, $message);
    }
}