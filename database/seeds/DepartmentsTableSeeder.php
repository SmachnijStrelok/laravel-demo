<?php

use App\Http\Components\Department\Entities\Department;
use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        factory(Department::class, 15)->create();

    }
}
