<?php
namespace App\Http\Components\User\Repositories\Contracts;

use App\Http\Components\User\Entities\UserToken;

interface IUserTokenRepository
{
    public function getByAccessToken(string $token): ?UserToken;

    public function getByRefreshToken(string $token): ?UserToken;

    public function save(UserToken $token): ?UserToken;

    public function delete(UserToken $token): ?bool;

    public function deleteAllToUser(int $userId): ?bool;
}