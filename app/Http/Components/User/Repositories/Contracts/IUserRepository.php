<?php
namespace App\Http\Components\User\Repositories\Contracts;


use App\Http\Components\User\Entities\User;

interface IUserRepository
{
    public function create(User $user): User;

    public function save(User $user): User;

    public function activate(int $id): ?bool;

    public function changePassword(int $userId, string $passwordHash): ?bool;

    /** @return User[]|null */
    public function getByRole(string $role): ?array;

    public function getById(int $id): ?User;

    public function getByMobilePhone(int $phone): ?User;

    public function getByEmail(string $email): ?User;

    public function getByLogin(string $login): ?User;

    public function getByLoginAndPassword(string $login, string $password): ?User;

    public function getByAccessToken(string $accessToken): ?User;

    public function me(): ?User;

    public function delete(User $user): ?bool;
}