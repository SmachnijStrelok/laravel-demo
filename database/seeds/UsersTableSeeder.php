<?php

use App\Http\Components\User\Entities\User;
use App\Http\Components\User\SignUp\Services\PasswordHasher;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    private PasswordHasher $hasher;
    public function __construct(PasswordHasher $hasher)
    {
        $this->hasher = $hasher;
    }

    /**
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'surname' => 'Ivanov',
            'name' => 'Ivan',
            'patronymic' => 'Ivanovich',
            'mobile_phone' => '89999999999',
            'email' => 'admin@test.loc',
            'role' => User::ROLE_ADMIN,
            'state' => User::STATE_ACTIVE,
            'password_hash' => $this->hasher->hash('password'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        factory(\App\Http\Components\User\Entities\User::class, 15)->create();

    }
}
