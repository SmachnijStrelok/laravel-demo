<?php
namespace App\Http\Components\User\Repositories;

use App\Http\Components\User\Entities\DepartmentToUser;
use App\Http\Components\User\Repositories\Contracts\IDepartmentToUsersRepository;

class DepartmentToUserRepository implements IDepartmentToUsersRepository
{
    public function save(DepartmentToUser $departmentToUser): ?DepartmentToUser
    {
        if(!$departmentToUser->save()){
            throw new \DomainException('Не удалось сохранить отдел для пользователя');
        }
        return $departmentToUser;
    }

    public function delete(DepartmentToUser $departmentToUser): ?bool
    {
        return $departmentToUser->delete();
    }

}