<?php
namespace App\Http\Components\Settings\UseCase;

interface ISetting
{
    public function get(string $settingName): mixed;
}