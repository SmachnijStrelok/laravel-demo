<?php
namespace App\Http\Components\User\Repositories;

use App\Http\Components\User\Entities\UserToken;
use App\Http\Components\User\Repositories\Contracts\IUserTokenRepository;

class UserTokenRepository implements IUserTokenRepository
{

    public function getByAccessToken(string $token): ?UserToken
    {
        return UserToken::whereAccessToken($token)->first();
    }

    public function getByRefreshToken(string $token): ?UserToken
    {
        return UserToken::whereRefreshToken($token)->first();
    }

    public function save(UserToken $token): ?UserToken
    {
        if(!$token->save()){
            throw new \DomainException('Не удалось сохранить токен');
        }
        return $token;
    }

    public function delete(UserToken $token): ?bool
    {
        return $token->delete();
    }

    public function deleteAllToUser(int $userId): ?bool
    {
        return UserToken::where('user_id', $userId)->delete();
    }
}