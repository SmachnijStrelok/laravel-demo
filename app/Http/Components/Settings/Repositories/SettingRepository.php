<?php
namespace App\Http\Components\Settings\Repositories;

use App\Http\Components\Settings\Entities\Setting;
use App\Http\Components\Settings\Repositories\Contracts\ISettingRepository;

class SettingRepository implements ISettingRepository
{

    /**
     * @return Setting[]
     */
    public function getAll(): ?array
    {
        return Setting::get()->all();
    }

    public function getByName(string $name): ?Setting
    {
        return Setting::where('name', $name)->first();
    }

    public function save(Setting $setting): Setting
    {
        if (!$setting->save()) {
            throw new \DomainException('Не удалось сохранить настройку');
        }

        return $setting;
    }
}