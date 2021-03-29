<?php
namespace App\Http\Components\Settings\UseCase;

use App\Http\Components\Settings\Repositories\Contracts\IActualSettingRepository;
use App\Http\Components\User\Repositories\Contracts\IUserRepository;

class GetSettings
{
    private $actualSettingRepository;
    private $userRepository;

    public function __construct(IActualSettingRepository $actualSettingRepository, IUserRepository $userRepository)
    {
        $this->actualSettingRepository = $actualSettingRepository;
        $this->userRepository = $userRepository;
    }

    public function getAll(){
        $me = $this->userRepository->me();
        $userId = $me->id ?? null;
        if(!$userId){
            return $this->actualSettingRepository->getPublic($userId);
        }
        return $me->isAdmin() ? $this->actualSettingRepository->getAll($userId) : $this->actualSettingRepository->getPublic($userId);
    }
}