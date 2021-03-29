<?php
namespace App\Http\Components\User\Password\UseCase;

use App\Http\Components\User\Entities\User;
use App\Http\Components\User\Entities\UserToken;
use App\Http\Components\User\Repositories\Contracts\IUserRepository;
use App\Http\Components\User\Repositories\Contracts\IUserTokenRepository;
use App\Http\Components\User\SignUp\Services\PasswordHasher;
use Illuminate\Support\Facades\Auth;

class Update
{
    private $userRepository;
    private $hasher;
    private $tokenRepository;

    public function __construct(IUserRepository $userRepository, PasswordHasher $hasher, IUserTokenRepository $tokenRepository)
    {
        $this->userRepository = $userRepository;
        $this->hasher = $hasher;
        $this->tokenRepository = $tokenRepository;
    }

    public function update(int $userId, ?string $oldPassword, string $newPassword, UserToken $token)
    {
        $me = $this->userRepository->me();
        $userId = $me->isAdmin() ? $userId : $me->id;
        $user = $this->userRepository->getById($userId);

        if (
            !$this->isOldPasswordCorrect($user, $oldPassword) &&
            (
                !$me->isAdmin() ||
                $me->isAdmin() && $me->id === $userId
            )
        ) {
            throw new \DomainException('Неверный текущий пароль');
        }

        $user->password_hash = $this->hasher->hash($newPassword);
        $this->updateUser($user);
        $this->deleteUserTokens($userId);
        return $this->addNewToken($token);
    }

    private function isOldPasswordCorrect(User $me, ?string $oldPassword)
    {
        $encryptedPassword = $this->hasher->hash($oldPassword ?? '');
        if($me->password_hash != $encryptedPassword){
            return false;
        }
        return true;
    }

    private function updateUser(User $me)
    {
        return $this->userRepository->save($me);
    }

    private function deleteUserTokens(int $userId)
    {
        return $this->tokenRepository->deleteAllToUser($userId);
    }

    private function addNewToken(UserToken $token)
    {
        return $this->tokenRepository->save($token);
    }
}
