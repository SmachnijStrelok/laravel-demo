<?php
namespace App\Http\Components\User\Repositories;

use App\Http\Components\User\Entities\User;
use App\Http\Components\User\Repositories\Contracts\IUserRepository;
use Illuminate\Support\Facades\Auth;

class UserRepository implements IUserRepository
{

    public function create(User $user): User
    {
        if(!$user->save()){
            throw new \DomainException('Не удалось создать пользователя');
        }

        return $user;
    }

    public function getById(int $id): ?User
    {
        return User::whereId($id)->first();
    }

    /** @return User[]|null */
    public function getByRole(string $role): ?array
    {
        return User::whereRole($role)->get()->all();
    }

    public function getByPhone(int $phone): ?User
    {
        // TODO: Implement getByPhone() method.
    }

    public function getByEmail(string $email): ?User
    {
        return User::whereEmail($email)->first();
    }

    public function getByAccessToken(string $accessToken): ?User
    {
        // TODO: Implement getByAccessToken() method.
    }

    public function delete(User $user): ?bool
    {
        // TODO: Implement delete() method.
    }

    public function getByMobilePhone(int $phone): ?User
    {
        return User::whereMobilePhone($phone)->first();
    }

    public function save(User $user): User
    {
        if(!$user->save()){
            throw new \DomainException('Не удалось создать пользователя');
        }

        return $user;
    }

    public function activate(int $id): ?bool
    {
        return User::whereId($id)->update(['state' => User::STATE_ACTIVE]);
    }

    public function changePassword(int $userId, string $passwordHash): ?bool
    {
        return User::whereId($userId)->update(['password_hash' => $passwordHash]);
    }

    public function getByLogin(string $login): ?User
    {
        return User::where('mobile_phone', (int)$login)
            ->orWhere('email', $login)
            ->first();
    }

    public function getByLoginAndPassword(string $login, string $passwordHash): ?User
    {
        return User::where('password_hash', $passwordHash)
            ->where(function($q) use($login){
              $q->where('mobile_phone', (int)$login)
                  ->orWhere('email', $login);
                })->first();
    }

    public function me(): ?User
    {
        if(!Auth::user()){
            return null;
        }
        $userId = Auth::user()->id;
        return $this->getById($userId);
    }
}
