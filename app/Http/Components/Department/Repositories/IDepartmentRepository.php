<?php

namespace App\Http\Components\Department\Repositories;

use App\Http\Components\Department\Entities\Department;

interface IDepartmentRepository
{
    public function getAll(): array;

    public function getById(int $id): Department;

    public function paginate($perPage = null, $columns = [], $pageName = 'page', $page = null);

    public function save(Department $department): Department;

    public function delete(Department $department);
}