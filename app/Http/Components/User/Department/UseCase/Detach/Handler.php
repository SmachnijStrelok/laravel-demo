<?php

namespace App\Http\Components\User\Department\UseCase\Detach;

use App\Http\Components\User\Entities\DepartmentToUser;
use App\Http\Components\User\Repositories\Contracts\IDepartmentToUsersRepository;

class Handler
{
    private IDepartmentToUsersRepository $repository;

    public function __construct(IDepartmentToUsersRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(DepartmentToUser $departmentToUser): void
    {
        $this->repository->delete($departmentToUser);
    }

}