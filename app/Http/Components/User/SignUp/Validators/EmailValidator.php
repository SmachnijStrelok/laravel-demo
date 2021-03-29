<?php
namespace App\Http\Components\User\SignUp\Validators;

use App\Http\Components\User\Repositories\Contracts\IUserRepository;

class EmailValidator
{
    private $repository;

    public function __construct(IUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validate(string $email)
    {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            throw new \DomainException(trans('user.wrong_email_format'));
        }

        if ($this->repository->getByEmail($email)) {
            throw new \DomainException(trans('user.email_already_exists'));
        }
    }
}
