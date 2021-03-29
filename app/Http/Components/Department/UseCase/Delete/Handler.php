<?php

namespace App\Http\Components\Department\UseCase\Delete;

use App\Http\Components\Department\Entities\Department;
use App\Http\Components\Department\Repositories\IDepartmentRepository;

class Handler
{
    private IDepartmentRepository $repository;

    public function __construct(IDepartmentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(Department $department): void
    {
        $this->repository->delete($department);
    }

}