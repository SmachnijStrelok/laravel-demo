<?php
namespace App\Http\Components\Settings\Repositories\Contracts;

use App\Http\Components\Settings\Entities\Setting;

interface ISettingRepository
{
    /**
     * @return Setting[]
     */
    public function getAll(): ?array;

    public function getByName(string $name): ?Setting;

    public function save(Setting $setting): Setting;
}