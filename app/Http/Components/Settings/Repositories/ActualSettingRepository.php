<?php
namespace App\Http\Components\Settings\Repositories;

use App\Http\Components\Settings\Constants\SettingNames;
use App\Http\Components\Settings\Entities\ActualSetting;
use App\Http\Components\Settings\Repositories\Contracts\IActualSettingRepository;

class ActualSettingRepository implements IActualSettingRepository
{

    /**
     * @param int $userId
     * @return ActualSetting[]|null
     */
    public function getAll(?int $userId): ?array
    {
        $settings = ActualSetting::whereNull('user_id');
        if($userId){
            $settings->orWhere('user_id', $userId);
        }
            return $settings->get()->all();
    }

    /**
     * @param int $userId
     * @return ActualSetting[]|null
     */
    public function getPublic(?int $userId): ?array
    {
        $publicSettings = [
            SettingNames::IUL_PRICE,
            SettingNames::IUL_STORAGE_DAYS,
            SettingNames::PROSTOR_SMS_ENABLED
        ];
        $settings = ActualSetting::whereIn('name', $publicSettings)
            ->where(function($q) use($userId){
                $q->whereNull('user_id');
                if($userId){
                    $q->orWhere('user_id', $userId);
                }
            });

        return $settings->get()->all();
    }
}