<?php
namespace App\Http\Components\Settings\Services\Contracts;

interface ISettingExtractor
{
    public function getSettings(): array;
}