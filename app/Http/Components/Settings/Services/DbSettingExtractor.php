<?php
namespace App\Http\Components\Settings\Services;

use App\Http\Components\Settings\Constants\SettingNames;
use App\Http\Components\Settings\Repositories\Contracts\IActualSettingRepository;
use App\Http\Components\Settings\Services\Contracts\ISettingExtractor;
use App\Http\Components\User\Repositories\Contracts\IUserRepository;
use Illuminate\Support\Facades\Config;

class DbSettingExtractor implements ISettingExtractor
{
    private $settingRepository;
    private $userRepository;

    public function __construct(IActualSettingRepository $settingRepository, IUserRepository $userRepository)
    {
        $this->settingRepository = $settingRepository;
        $this->userRepository = $userRepository;
    }

    public function getSettings(): array
    {
        $me = $this->userRepository->me();
        $userId = $me->id ?? null;
        $allSettings = $this->settingRepository->getAll($userId);
        return $this->formatSettings($allSettings);
    }

    /**
     * @param $settings \App\Http\Components\Settings\Entities\ActualSetting[]
     * @return array
     */
    private function formatSettings(array $settings)
    {
        $result = [];
        foreach ($settings as $setting){
            $valueType = $setting->value_type;
            $valueColumn = $valueType . '_value';
            $result[$setting->name] = $setting->$valueColumn;
        }
        $this->addToConfig($result);
        return $result;
    }
    
    private function addToConfig(array $dbSettings)
    {
        $configSettings = $this->needAddToConfig();
        foreach ($configSettings as $configKey => $dbSettingName){
            if(!array_key_exists($dbSettingName, $dbSettings)){
                continue;
            }
            $dbSettingValue = $dbSettings[$dbSettingName];
            Config::set($configKey, $dbSettingValue);
        }
    }

    private function needAddToConfig()
    {
        return [
            'mail.host' => SettingNames::MAIL_HOST,
            'mail.port' => SettingNames::MAIL_PORT,
            'mail.username' => SettingNames::MAIL_USERNAME,
            'mail.password' => SettingNames::MAIL_PASSWORD,
            'mail.from.address' => SettingNames::MAIL_USERNAME
        ];
    }
}