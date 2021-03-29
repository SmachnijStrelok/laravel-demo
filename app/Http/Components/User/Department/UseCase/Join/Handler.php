<?php

namespace App\Http\Components\User\Department\UseCase\Join;

use App\Http\Components\User\Entities\DepartmentToUser;
use App\Http\Components\User\Repositories\Contracts\IDepartmentToUsersRepository;

class Handler
{
    private IDepartmentToUsersRepository $repository;

    public function __construct(IDepartmentToUsersRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(int $userId, int $departmentId): DepartmentToUser
    {
        $departmentToUser = new DepartmentToUser();
        $departmentToUser->department_id = $departmentId;
        $departmentToUser->user_id = $userId;

        return $this->repository->save($departmentToUser);
    }

}