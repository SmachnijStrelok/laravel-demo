<?php
namespace App\Http\Components\Settings\Repositories\Contracts;

use App\Http\Components\Settings\Entities\UserSetting;

interface IUserSettingRepository
{
    /**
     * @param int $userId
     * @return UserSetting[]|null
     */
    public function getAll(int $userId): ?array;

    public function save(UserSetting $setting): UserSetting;
}