<?php
namespace App\Http\Services\Sender;

use App\Http\Components\Settings\Constants\SettingNames;
use App\Http\Components\Settings\Setting;

class SmsSender
{
    private $setting;

    public function __construct(Setting $setting)
    {
        $this->setting = $setting;
    }

    public function send($phone, $message){
        $phone = $this->formatPhone($phone);
        $sender = (string)$this->setting->get(SettingNames::PROSTOR_SMS_SENDER);
        $sender = $this->encodeSender($sender);
        $message = $this->encodeMessage($message);

        $login = $this->setting->get(SettingNames::PROSTOR_SMS_LOGIN);
        $password = $this->setting->get(SettingNames::PROSTOR_SMS_PASSWORD);

        $url = "https://" .$login. ":" .$password. "@api.prostor-sms.ru/send/?phone="
            .$phone. "&text=".$message."&sender=".$sender;

        $response = file_get_contents($url);
        $sent = strpos($response, 'accepted');

        if(!$sent){
            throw new \DomainException('Сообщение не было отправлено ' . $response);
        }

        return true;
    }

    private function formatPhone($phone)
    {
        $phone = (string)$phone;
        $phone[0] = 7;
        return $phone;
    }

    private function encodeSender(string $sender)
    {
        return rawurlencode($sender);
    }

    private function encodeMessage(string $message)
    {
        return rawurlencode($message);
    }
}