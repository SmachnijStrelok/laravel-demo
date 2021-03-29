<?php

namespace Tests\Unit;

use App\Http\Components\Department\Entities\Department;
use App\Http\Components\Department\Repositories\IDepartmentRepository;
use App\Http\Components\Department\UseCase\Update as Update;
use App\Http\Components\Department\UseCase\Create as Create;
use App\Http\Components\Department\UseCase\Delete as Delete;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class DepartmentHandlersTest extends TestCase
{
    /**
     * @return void
     */
    public function testSaveDepartment()
    {
        $departmentRepository = $this->createMock(IDepartmentRepository::class);
        $department = new Department(['name' => 'aaa', 'description' => 'bbb', 'logo_id' => null]);
        $departmentRepository->method('save')->willReturn($department);
        $updateHandler = new Create\Handler($departmentRepository);

        $this->assertEquals($updateHandler->handle($department), $department);
    }

    public function testUpdateDepartment()
    {
        $departmentRepository = $this->createMock(IDepartmentRepository::class);
        $department = new Department(['name' => 'aaa', 'description' => 'bbb', 'logo_id' => null]);
        $departmentRepository->method('save')->willReturn($department);
        $updateHandler = new Update\Handler($departmentRepository);

        $this->assertEquals($updateHandler->handle($department), $department);
    }

    public function testDeleteDepartment()
    {
        $departmentRepository = $this->createMock(IDepartmentRepository::class);
        $department = new Department(['name' => 'aaa', 'description' => 'bbb', 'logo_id' => null]);
        $departmentRepository->method('save')->willReturn($department);
        $updateHandler = new Delete\Handler($departmentRepository);

        $this->assertNull($updateHandler->handle($department));
    }
}
