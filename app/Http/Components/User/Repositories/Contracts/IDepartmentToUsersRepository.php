<?php

namespace App\Http\Components\User\Repositories\Contracts;

use App\Http\Components\User\Entities\DepartmentToUser;

interface IDepartmentToUsersRepository
{
    public function save(DepartmentToUser $departmentToUser): ?DepartmentToUser;

    public function delete(DepartmentToUser $departmentToUser): ?bool;
}