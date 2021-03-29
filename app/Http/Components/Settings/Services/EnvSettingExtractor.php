<?php
namespace App\Http\Components\Settings\Services;

use App\Http\Components\Settings\Services\Contracts\ISettingExtractor;
use App\Http\Components\Settings\Constants\SettingNames as Settings;

class EnvSettingExtractor implements ISettingExtractor
{
    public function getSettings(): array
    {
        return [
            Settings::APP_URL => env(Settings::APP_URL),
            Settings::APP_TYPE => env(Settings::APP_TYPE, 'box'),
            Settings::APP_EMAIL_CONFIRMATION_URI => env(Settings::APP_EMAIL_CONFIRMATION_URI),
        ];
    }
}