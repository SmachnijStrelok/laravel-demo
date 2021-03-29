<?php
namespace App\Http\Components\User\MobilePhone\UseCase;

use App\Http\Components\User\Entities\User;
use App\Http\Components\User\Entities\UserConfirmation;
use App\Http\Components\User\Entities\UserToken;
use App\Http\Components\User\Repositories\Contracts\IUserConfirmationRepository;
use App\Http\Components\User\Repositories\Contracts\IUserRepository;

class ResetConfirm
{
    private $userRepository;
    private $confirmationRepository;

    public function __construct(
        IUserRepository $userRepository,
        IUserConfirmationRepository $confirmationRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->confirmationRepository = $confirmationRepository;
    }

    public function confirm(string $code)
    {
        $user = $this->userRepository->me();
        $lastActivation = $this->confirmationRepository->getLastActiveByUser($user->id, UserConfirmation::ACTION_MOBILE_PHONE_UPDATE);
        if (!$lastActivation) {
            throw new \DomainException('Нет доступных попыток для активации');
        }

        if ($lastActivation->code != $code) {
            $lastActivation->attempt += 1;
            $errorMessage = $this->updateWrongCode($lastActivation);
            throw new \DomainException($errorMessage);
        }

        $this->updateCorrectCode($lastActivation);
        $user = $this->updateUserPhone($user, $lastActivation->sent_to);

        return $user;

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

    private function updateUserPhone(User $user, string $newPhone)
    {
        $user->mobile_phone = $newPhone;
        return $this->userRepository->save($user);
    }
}