<?php
namespace App\Http\Components\User\SignUp\Services;

class EmailConfirmLinkGenerator
{
    public function generateEmailLink(int $userId, string $activationCode)
    {
        $params = $this->createParamsArray($userId, $activationCode);
        $confirmationUri = $this->buildConfirmationUri(env('APP_EMAIL_CONFIRMATION_URI'), $params);
        return env('APP_URL') . $confirmationUri;
    }

    private function createParamsArray(int $userId, string $activationCode)
    {
        return [$userId, $activationCode];
    }

    private function buildConfirmationUri(string $formatUri, $params = [])
    {
        return sprintf($formatUri, ...$params);
    }
}