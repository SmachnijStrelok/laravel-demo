<?php
namespace App\Http\Components\User\SignUp\UseCase;

use App\Http\Components\User\Entities\User;
use App\Http\Components\User\Repositories\Contracts\IUserConfirmationRepository;
use App\Http\Components\User\Repositories\Contracts\IUserRepository;
use App\Http\Components\User\SignUp\Services\SignUpFactory;

class CodeResent
{
    private $userRepository;
    private $confirmationRepository;
    private $factory;

    public function __construct(IUserRepository $userRepository, IUserConfirmationRepository $confirmationRepository, SignUpFactory $factory)
    {
        $this->userRepository = $userRepository;
        $this->confirmationRepository = $confirmationRepository;
        $this->factory = $factory;
    }

    public function resent(int $userId)
    {
        $user = $this->userRepository->getById($userId);
        if(!$user){
            throw new \DomainException('Пользователь не найден');
        }
        if($user->state != User::STATE_UNCONFIRMED){
            throw new \DomainException('Пользователь уже подтвержден');
        }

        $this->sendConfirmationMessage($user);
    }

    private function sendConfirmationMessage(User $user)
    {
        $firstConfirmation = $this->confirmationRepository->getFirstAccountActivation($user->id);
        if(!$firstConfirmation){
            throw new \DomainException('Не удалось определить тип регистрации');
        }

        $registerType = $firstConfirmation->type;
        $sender = $this->factory->makeSignUpRequestHandler($registerType);
        $sender->sendConfirmation($user);
    }
}