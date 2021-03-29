<?php
namespace App\Http\Components\User\Entities;

class UserInfo
{
    public $surname;
    public $name;
    public $patronymic;

    public function __construct(string $surname, string $name, string $patronymic)
    {
        $this->surname = $surname;
        $this->name = $name;
        $this->patronymic = $patronymic;
    }
}