<?php
namespace App\Http\Components\Settings\UseCase;

use App\Http\Components\Settings\Repositories\Contracts\ISettingRepository;
use App\Http\Components\User\Repositories\Contracts\IUserRepository;

class UpdateSystemSettings
{
    private $settingRepository;
    private $userRepository;

    public function __construct(ISettingRepository $settingRepository, IUserRepository $userRepository)
    {
        $this->settingRepository = $settingRepository;
        $this->userRepository = $userRepository;
    }

    public function update(array $settings){
        $me = $this->userRepository->me();
        if(!$me->isAdmin()){
            throw new \DomainException('access denied');
        }

        foreach ($settings as $setting){
            $this->updateSetting($setting['name'], $setting['value']);
        }
    }

    private function updateSetting($settingName, $settingValue)
    {
        if(!$systemSetting = $this->settingRepository->getByName($settingName)){
            throw new \DomainException('Настройка не найдена');
        }

        $systemSetting->setValue($settingValue);
        $this->settingRepository->save($systemSetting);
    }
}