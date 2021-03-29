<?php
namespace App\Http\Components\User\SignUp\UseCase;

use App\Http\Components\User\Entities\UserConfirmation;
use App\Http\Components\User\Entities\UserToken;
use App\Http\Components\User\Repositories\Contracts\IUserConfirmationRepository;
use App\Http\Components\User\Repositories\Contracts\IUserRepository;
use App\Http\Components\User\Repositories\Contracts\IUserTokenRepository;

class Confirm
{
    private $userRepository;
    private $confirmationRepository;
    private $tokenRepository;

    public function __construct(
        IUserRepository $userRepository, 
        IUserConfirmationRepository $confirmationRepository,
        IUserTokenRepository $tokenRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->confirmationRepository = $confirmationRepository;
        $this->tokenRepository = $tokenRepository;
    }

    public function confirm(string $code, UserToken $token)
    {
        $lastActivationCode = $this->confirmationRepository->getLastActiveByUser($token->user_id);
        if(!$lastActivationCode){
            throw new \DomainException('Нет доступных попыток для активации');
        }

        if($lastActivationCode->code != $code){
            $lastActivationCode->attempt += 1;
            $errorMessage = $this->updateWrongCode($lastActivationCode);
            throw new \DomainException($errorMessage);
        }

        $this->updateCorrectCode($lastActivationCode);
        $token = $this->saveTokenToUser($token);
        $this->activateUser($token->user_id);

        return $token;

    }

    private function updateWrongCode(UserConfirmation $lastActivationCode)
    {
        $errorMessage = 'Неверный код подтверждения';
        $isLastAttempt = ($lastActivationCode->attempt == $lastActivationCode::ATTEMPT_MAX_COUNT);
        if($isLastAttempt){
            $lastActivationCode->is_active = false;
            $errorMessage .= ', все попытки использованы';
        }
        $this->confirmationRepository->save($lastActivationCode);
        return $errorMessage;
    }

    private function updateCorrectCode(UserConfirmation $lastActivationCode)
    {
        $lastActivationCode->is_active = false;
        $this->confirmationRepository->save($lastActivationCode);
    }

    private function saveTokenToUser(UserToken $token): UserToken
    {
        return $this->tokenRepository->save($token);
    }

    private function activateUser(int $userId)
    {
        return $this->userRepository->activate($userId);
    }
}