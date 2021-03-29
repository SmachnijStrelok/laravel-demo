<?php
namespace App\Http\Components\User\Repositories;

use App\Http\Components\User\Entities\UserConfirmation;
use App\Http\Components\User\Repositories\Contracts\IUserConfirmationRepository;

class UserConfirmationRepository implements IUserConfirmationRepository
{

    public function getLastActiveByUser(int $userId, ?string $action = null): ?UserConfirmation
    {
        $action = $action ?? UserConfirmation::ACTION_SIGN_UP;
        return UserConfirmation::where('user_id', $userId)
            ->where('is_active', true)
            ->where('action', $action)
            ->orderByDesc('id')
            ->first();
    }

    public function getLastActiveByTypeAndUser(int $userId, string $type): ?UserConfirmation
    {
        return UserConfirmation::where('user_id', $userId)
            ->where('is_active', true)
            ->where('type', $type)
            ->orderByDesc('id')
            ->first();
    }

    public function createAndDeactivatePrevious(UserConfirmation $confirmation, string $type): ?UserConfirmation
    {
        UserConfirmation::where('user_id', $confirmation->user_id)
            ->where('type', $type)
            ->where('is_active', true)
            ->update(['is_active' => false]);

        if(!$confirmation->save()){
            throw new \DomainException('Не удалось сохранить код подтверждения');
        }

        return $confirmation;
    }

    public function getFirstAccountActivation(int $userId): ?UserConfirmation
    {
         return UserConfirmation::where('user_id', $userId)
            ->where('action', UserConfirmation::ACTION_SIGN_UP)
            ->orderBy('id')
            ->first();
    }

    public function save(UserConfirmation $confirmation): ?UserConfirmation
    {
        if(!$confirmation->save()){
            throw new \DomainException('Не удалось обновить код подтверждения');
        }
        return $confirmation;
    }

    public function delete(UserConfirmation $confirmation): ?bool
    {
        return $confirmation->delete();
    }
}