<?php
namespace App\Http\Components\User\Repositories\Contracts;

use App\Http\Components\User\Entities\UserConfirmation;

interface IUserConfirmationRepository
{
    public function getLastActiveByUser(int $userId, ?string $action = null): ?UserConfirmation;

    public function getLastActiveByTypeAndUser(int $userId, string $type): ?UserConfirmation;

    public function getFirstAccountActivation(int $userId): ?UserConfirmation;

    public function createAndDeactivatePrevious(UserConfirmation $confirmation, string $type): ?UserConfirmation;

    public function save(UserConfirmation $confirmation): ?UserConfirmation;

    public function delete(UserConfirmation $confirmation): ?bool;

}