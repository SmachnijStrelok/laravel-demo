<?php

namespace Tests\Feature;

use App\Http\Components\Department\Entities\Department;
use App\Http\Components\User\Entities\User;
use App\Http\Middleware\TokenAuthenticator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DepartmentTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $user = User::where('role', User::ROLE_ADMIN)->first();
        $this->be($user);
        $this->withoutMiddleware(TokenAuthenticator::class);
    }

    public function testDepartmentExists(): void
    {
        $response = $this->get('/api/departments/get-by-id/3');
        $response->assertStatus(200);
    }

    public function testDepartmentValid(): void
    {
        $response = $this->get('/api/departments/get-by-id/3');
        $decodedResponse = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('state', $decodedResponse);
        $this->assertArrayHasKey('data', $decodedResponse);

        $department = $decodedResponse['data'];
        $this->assertArrayHasKey('name', $department);
        $this->assertArrayHasKey('description', $department);
        $this->assertArrayHasKey('logo_id', $department);
    }

    public function testCreateDepartment()
    {
        $data = [
            'name' => 'my_name',
            'description' => 'my_description',
            'logo_id' => null,
        ];

        $response = $this->postJson('/api/departments/create', $data);
        $response->assertStatus(201);
    }

    public function testEditDepartment()
    {
        $data = [
            'name' => 'my_name2',
            'description' => 'my_description2',
            'logo_id' => null,
        ];
        $departmentId = Department::pluck('id')->first();
        $response = $this->putJson('/api/departments/update/'.$departmentId, $data);
        $response->assertStatus(200);

        $response = $this->get('/api/departments/get-by-id/'.$departmentId);
        $decodedResponse = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('state', $decodedResponse);
        $this->assertArrayHasKey('data', $decodedResponse);

        $department = $decodedResponse['data'];
        $this->assertArrayHasKey('name', $department);
        $this->assertArrayHasKey('description', $department);
        $this->assertArrayHasKey('logo_id', $department);

        $this->assertEquals($department['name'], $data['name']);
        $this->assertEquals($department['description'], $data['description']);
        $this->assertEquals($department['logo_id'], $data['logo_id']);
    }
}
