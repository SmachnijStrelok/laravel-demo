<?php
namespace App\Http\Components\User\Auth\UseCase;

use App\Http\Components\User\Entities\UserToken;
use App\Http\Components\User\Repositories\Contracts\IUserRepository;
use App\Http\Components\User\Repositories\Contracts\IUserTokenRepository;
use App\Http\Components\User\SignUp\Services\PasswordHasher;

class Login
{
    private $userRepository;
    private $hasher;
    private $tokenRepository;

    public function __construct(IUserRepository $userRepository, IUserTokenRepository $tokenRepository, PasswordHasher $hasher)
    {
        $this->userRepository = $userRepository;
        $this->hasher = $hasher;
        $this->tokenRepository = $tokenRepository;
    }

    public function login(string $login, string $password, UserToken $token)
    {
        $passwordHash = $this->hasher->hash($password);
        if(!$user = $this->userRepository->getByLoginAndPassword($login, $passwordHash)){
            throw new \DomainException('Неверный логин или пароль');
        }
        $token->user_id = $user->id;
        $token = $this->saveToken($token);

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    private function saveToken(UserToken $token)
    {
        return $this->tokenRepository->save($token);
    }
}