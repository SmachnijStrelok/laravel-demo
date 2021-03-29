<?php
namespace App\Http\Components\User\Password\UseCase;

use App\Http\Components\User\Entities\User;
use App\Http\Components\User\Entities\UserConfirmation;
use App\Http\Components\User\Entities\UserToken;
use App\Http\Components\User\Repositories\Contracts\IUserConfirmationRepository;
use App\Http\Components\User\Repositories\Contracts\IUserRepository;
use App\Http\Components\User\Repositories\Contracts\IUserTokenRepository;
use App\Http\Components\User\SignUp\Services\PasswordHasher;

class ResetConfirm
{
    private $userRepository;
    private $confirmationRepository;
    private $tokenRepository;
    private $hasher;

    public function __construct(
        IUserRepository $userRepository,
        IUserConfirmationRepository $confirmationRepository,
        IUserTokenRepository $tokenRepository,
        PasswordHasher $hasher
    )
    {
        $this->userRepository = $userRepository;
        $this->confirmationRepository = $confirmationRepository;
        $this->tokenRepository = $tokenRepository;
        $this->hasher = $hasher;
    }

    public function confirm(string $code, UserToken $token, string $password)
    {
        $lastActivationCode = $this->confirmationRepository->getLastActiveByUser($token->user_id, UserConfirmation::ACTION_PASSWORD_RESET);
        if (!$lastActivationCode) {
            throw new \DomainException('Нет доступных попыток для активации');
        }

        if ($lastActivationCode->code != $code) {
            $lastActivationCode->attempt += 1;
            $errorMessage = $this->updateWrongCode($lastActivationCode);
            throw new \DomainException($errorMessage);
        }
        $me = $this->userRepository->getById($token->user_id);

        $this->updateCorrectCode($lastActivationCode);
        $this->deleteUserTokens($me->id);
        $token = $this->saveTokenToUser($token);
        $me = $this->activateUser($me->id);
        $this->updateUserPassword($me, $password);

        return $token;

    }

    private function updateWrongCode(UserConfirmation $lastActivationCode)
    {
        $errorMessage = 'Неверный код подтверждения';
        $isLastAttempt = ($lastActivationCode->attempt == $lastActivationCode::ATTEMPT_MAX_COUNT);
        if ($isLastAttempt) {
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

    private function deleteUserTokens(int $userId)
    {
        return $this->tokenRepository->deleteAllToUser($userId);
    }

    private function updateUserPassword(int $userId, string $password){
        return $this->userRepository->changePassword($userId, $this->hasher->hash($password));
    }
}