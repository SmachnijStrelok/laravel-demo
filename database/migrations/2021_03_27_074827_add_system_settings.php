<?php

use App\Http\Components\Settings\Constants\SettingGroups;
use App\Http\Components\Settings\Constants\SettingNames as Settings;
use App\Http\Components\Settings\Constants\ValueTypes as Type;
use Illuminate\Database\Migrations\Migration;

class AddSystemSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $settings = [
            [
                'name' => Settings::PROSTOR_SMS_LOGIN,
                'description' => 'Логин',
                'value_type' => Type::STRING,
                'string_value' => null,
                'group_name' => SettingGroups::PROSTOR_SMS
            ],
            [
                'name' => Settings::PROSTOR_SMS_PASSWORD,
                'description' => 'Пароль',
                'value_type' => Type::STRING,
                'string_value' => null,
                'group_name' => SettingGroups::PROSTOR_SMS
            ],
            [
                'name' => Settings::PROSTOR_SMS_SENDER,
                'description' => 'Отправитель',
                'value_type' => Type::STRING,
                'string_value' => null,
                'group_name' => SettingGroups::PROSTOR_SMS
            ],
            [
                'name' => Settings::PROSTOR_SMS_ENABLED,
                'description' => 'Включена ли отправка смс',
                'value_type' => Type::BOOLEAN,
                'boolean_value' => false,
                'group_name' => SettingGroups::PROSTOR_SMS
            ],
            [
                'name' => Settings::MAIL_HOST,
                'description' => 'Хост',
                'value_type' => Type::STRING,
                'string_value' => null,
                'group_name' => SettingGroups::MAIL
            ],
            [
                'name' => Settings::MAIL_PORT,
                'description' => 'Порт',
                'value_type' => Type::NUMBER,
                'number_value' => null,
                'group_name' => SettingGroups::MAIL
            ],
            [
                'name' => Settings::MAIL_USERNAME,
                'description' => 'Имя пользователя',
                'value_type' => Type::STRING,
                'string_value' => null,
                'group_name' => SettingGroups::MAIL
            ],
            [
                'name' => Settings::MAIL_PASSWORD,
                'description' => 'Пароль',
                'value_type' => Type::STRING,
                'string_value' => null,
                'group_name' => SettingGroups::MAIL
            ],
        ];

        foreach ($settings as $setting){
            \Illuminate\Support\Facades\DB::table('settings')->insert($setting);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Illuminate\Support\Facades\DB::table('settings')->truncate();
    }
}
