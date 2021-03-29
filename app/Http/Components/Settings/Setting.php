<?php
namespace App\Http\Components\Settings;

use App\Http\Components\Settings\Services\Contracts\ISettingExtractor;
use App\Http\Components\Settings\Services\DbSettingExtractor;
use App\Http\Components\Settings\Services\EnvSettingExtractor;

class Setting
{
    /**
     * Все настройки в виде ['name' => 'value', ...]
     * @var array
     */
    protected $settings = [];

    public function __construct()
    {
        $result = [];
        foreach ($this->getExtractors() as $extractor){
            /** @var $extractor ISettingExtractor */
            $extractor = resolve($extractor);
            $result = array_merge($result, $extractor->getSettings());
        }
        $this->settings = $result;
    }

    public function get(string $settingName)
    {
        if(!array_key_exists($settingName, $this->settings)){
            throw new \DomainException('Setting not found');
        }
        return $this->settings[$settingName];
    }

    private function getExtractors()
    {
        return [
            DbSettingExtractor::class,
            EnvSettingExtractor::class,
        ];
    }
}