<?php
namespace App\Http\Components\Settings\Controllers;

use App\Http\Components\Settings\UseCase\GetSettings;
use App\Http\Components\Settings\UseCase\UpdateSystemSettings;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SystemSettingController extends Controller
{
    /**
     * @param Request $request
     * @param GetSettings $settings
     * @return \App\Http\Components\Settings\Entities\ActualSetting[]|array|null
     */
    public function get(Request $request, GetSettings $settings)
    {
        return $settings->getAll();
    }

    /**
     * @param Request $request
     * @param UpdateSystemSettings $settings
     */
    public function update(Request $request, UpdateSystemSettings $settings)
    {
        $settings->update($request->input('settings'));
    }
}