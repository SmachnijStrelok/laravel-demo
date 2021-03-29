<?php
namespace App\Http\Components\User\SignUp\Services\RequestHandlers;

use App\Http\Components\User\Entities\User;

interface IRequestHandler
{
    public function register(User $user): User;

    public function sendConfirmation(User $user, ?string $action = null);
}