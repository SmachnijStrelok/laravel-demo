<?php
namespace App\Http\Components\User\Password\UseCase;

use App\Http\Components\User\Entities\UserConfirmation;
use App\Http\Components\User\Repositories\Contracts\IUserRepository;
use App\Http\Components\User\SignUp\Services\SignUpFactory;

class ResetRequest
{
    private $userRepository;
    private $signUpFactory;

    public function __construct(IUserRepository $userRepository, SignUpFactory $signUpFactory)
    {
        $this->userRepository = $userRepository;
        $this->signUpFactory = $signUpFactory;
    }

    public function reset(string $login, string $resetType)
    {
        if(!$user = $this->userRepository->getByLogin($login)){
            throw new \DomainException('Пользователь не найден');
        }
        $sender = $this->signUpFactory->makeSignUpRequestHandler($resetType);
        $sender->sendConfirmation($user, UserConfirmation::ACTION_PASSWORD_RESET);
    }
}
