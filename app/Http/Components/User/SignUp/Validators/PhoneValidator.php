<?php
namespace App\Http\Components\User\SignUp\Validators;

use App\Http\Components\User\Repositories\Contracts\IUserRepository;

class PhoneValidator
{
    private $repository;

    public function __construct(IUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validate(int $mobilePhone)
    {
        if(strlen((string)$mobilePhone) != 11){
            throw new \DomainException(trans('user.wrong_phone_format'));
        }

        if ($this->repository->getByMobilePhone($mobilePhone)) {
            throw new \DomainException(trans('user.phone_already_exists'));
        }
    }
}
