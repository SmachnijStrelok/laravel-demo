<?php
namespace App\Http\Components\User\SignUp\Services;

class PasswordHasher
{
    public function hash(string $password)
    {
        return md5(md5($password));
    }
}