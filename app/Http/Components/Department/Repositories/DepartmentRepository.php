<?php

namespace App\Http\Components\Department\Repositories;

use App\Http\Components\Department\Entities\Department;

class DepartmentRepository implements IDepartmentRepository
{

    /**
     * @return Department[]
     */
    public function getAll(): array
    {
        return Department::get()->all();
    }

    public function getById(int $id): Department
    {
        return Department::findOrFail($id);
    }

    /**
     * @param null $perPage
     * @param array $columns
     * @param string $pageName
     * @param null $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage = null, $columns = [], $pageName = 'page', $page = null)
    {
        return Department::paginate($perPage, $columns, $pageName, $page);
    }

    /**
     * @param Department $department
     * @return Department
     */
    public function save(Department $department): Department
    {
        if(!$department->save()){
            throw new \DomainException('Не удалось сохранить отдел!');
        }

        return $department;
    }

    /**
     * @param Department $department
     * @throws \Exception
     */
    public function delete(Department $department): void
    {
        $department->delete();
    }
}