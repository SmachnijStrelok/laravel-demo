<?php
namespace App\Http\Components\User\UserInfo\UseCase;

use App\Http\Components\User\Entities\User;
use App\Http\Components\User\Entities\UserInfo;
use App\Http\Components\User\Repositories\Contracts\IUserRepository;
use Illuminate\Support\Facades\Auth;

class Edit
{
    private $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function edit(int $userId, UserInfo $userInfo)
    {
        $userId = Auth::user()->isAdmin() ? $userId : Auth::user()->id;
        if(!$user = $this->userRepository->getById($userId)){
            throw new \DomainException('Пользователь не найден');
        }
        $filledUser = $this->fillUserFromDTO($user, $userInfo);
        return $this->saveUser($filledUser);
    }

    private function fillUserFromDTO(User $user, UserInfo $userInfo): User
    {
        $user->surname = $userInfo->surname;
        $user->name = $userInfo->name;
        $user->patronymic = $userInfo->patronymic;
        return $user;
    }

    private function saveUser(User $user)
    {
        return $this->userRepository->save($user);
    }
}