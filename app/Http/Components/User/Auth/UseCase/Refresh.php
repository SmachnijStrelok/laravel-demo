<?php
namespace App\Http\Components\User\Auth\UseCase;

use App\Http\Components\User\Entities\UserToken;
use App\Http\Components\User\Repositories\Contracts\IUserTokenRepository;

class Refresh
{
    private $tokenRepository;

    public function __construct(IUserTokenRepository $tokenRepository)
    {
        $this->tokenRepository = $tokenRepository;
    }

    /**
     * @param string $refreshToken
     * @param UserToken $newToken
     * @return UserToken|null
     */
    public function refresh(string $refreshToken, UserToken $newToken)
    {
        if(!$token = $this->tokenRepository->getByRefreshToken($refreshToken)){
            throw new \DomainException('Неверный токен');
        }

        $newToken->user_id = $token->user_id;

        if(!$this->tokenRepository->delete($token)){
            throw new \DomainException('Не удалось удалить предыдущий токен');
        }
        return $this->saveToken($newToken);
    }

    /**
     * @param UserToken $token
     * @return UserToken|null
     */
    private function saveToken(UserToken $token)
    {
        return $this->tokenRepository->save($token);
    }
}