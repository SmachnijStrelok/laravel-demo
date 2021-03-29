<?php

use App\Http\Components\Department\Entities\Department;
use App\Http\Components\User\Entities\User;
use Illuminate\Database\Seeder;

class DepartmentToUsersTableSeeder extends Seeder
{
    private array $userIds;
    private array $departmentIds;

    public function __construct()
    {
        $this->userIds = User::whereRole(User::ROLE_USER)->pluck('id')->toArray();
        $this->departmentIds = Department::pluck('id')->toArray();
    }

    /**
     * @return void
     */
    public function run(): void
    {
        $data = $this->addOneDepartmentToOneUser();

        DB::table('department_to_users')->insert($data);

    }

    /**
     * @param array $userIds
     * @param array $departmentIds
     * @return array
     */
    private function addOneDepartmentToOneUser(): array
    {
        $data = [];
        foreach ($this->userIds as $userId){
            shuffle($this->departmentIds);
            for($i = 0; $i < rand(1, 4); $i ++){
                $data[] = [
                    'user_id' => $userId,
                    'department_id' => $this->departmentIds[$i]
                ];
            }
        }

        return $data;
    }
}
