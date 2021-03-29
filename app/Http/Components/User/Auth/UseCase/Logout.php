<?php
namespace App\Http\Components\User\Auth\UseCase;

use App\Http\Components\User\Repositories\Contracts\IUserTokenRepository;

class Logout
{
    private $tokenRepository;

    public function __construct(IUserTokenRepository $tokenRepository)
    {
        $this->tokenRepository = $tokenRepository;
    }

    public function logout(string $accessToken)
    {
        if(!$token = $this->tokenRepository->getByAccessToken($accessToken)){
            throw new \DomainException('Не удалось найти токен');
        }
        if(!$this->tokenRepository->delete($token)){
            throw new \DomainException('Не удалось разлогиниться');
        }
    }
}