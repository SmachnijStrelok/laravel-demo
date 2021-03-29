<?php
namespace App\Http\Components\Settings\Repositories\Contracts;


use App\Http\Components\Settings\Entities\ActualSetting;

interface IActualSettingRepository
{
    /**
     * @param int $userId
     * @return ActualSetting[]|null
     */
    public function getAll(?int $userId): ?array;

    /**
     * @param int $userId
     * @return ActualSetting[]|null
     */
    public function getPublic(?int $userId): ?array;
}