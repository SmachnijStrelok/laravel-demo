<?php

namespace App\Http\Components\Department\Controllers;

use App\Http\Components\Department\Entities\Department;
use App\Http\Components\Department\Repositories\IDepartmentRepository;
use App\Http\Components\Department\UseCase\Create as Create;
use App\Http\Components\Department\UseCase\Update as Update;
use App\Http\Components\Department\UseCase\Delete as Delete;
use App\Http\Controllers\Controller;
use App\Http\Resources\DepartmentResource;
use App\Http\Resources\DepartmentsCollectionResource;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * @param Request $request
     * @param IDepartmentRepository $repository
     * @return DepartmentsCollectionResource
     */
    public function getAll(Request $request, IDepartmentRepository $repository){
        return new DepartmentsCollectionResource(Department::paginate(5));
    }

    /**
     * @param Request $request
     * @param IDepartmentRepository $repository
     * @return DepartmentResource
     */
    public function get(Request $request, IDepartmentRepository $repository){
        return new DepartmentResource($repository->getById($request->route('id')));
    }

    /**
     * @param Create\CreateDepartmentRequest $request
     * @param Create\Handler $handler
     * @return DepartmentResource
     */
    public function create(Create\CreateDepartmentRequest $request, Create\Handler $handler){
        $department = new Department();
        $department->fill($request->all());
        return new DepartmentResource($handler->handle($department));
    }

    /**
     * @param Update\UpdateDepartmentRequest $request
     * @param Update\Handler $handler
     * @param Department $department
     * @return DepartmentResource
     */
    public function update(Update\UpdateDepartmentRequest $request, Update\Handler $handler, Department $department){
        $department->name = $request->get('name');
        $department->description = $request->get('description');
        $department->logo_id = $request->get('logo_id');
        return new DepartmentResource($handler->handle($department));
    }

    /**
     * @param Delete\Handler $handler
     * @param Department $department
     * @return string
     */
    public function delete(Delete\Handler $handler, Department $department){
        $handler->handle($department);
        return "ok";
    }
}