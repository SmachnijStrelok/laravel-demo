<?php
namespace App\Http\Components\User\SignUp\Services;

use App\Http\Components\User\Entities\UserToken;
use Ramsey\Uuid\Uuid;

class TokenGenerator
{
    const SIX_HOURS = 60*60*6;

    public function generate()
    {
        $token = new UserToken();
        $token->access_token = $this->generateAccessToken();
        $token->refresh_token = $this->generateRefreshToken();
        $token->expires_in = $this->getExpiresIn();
        return $token;
    }

    private function generateAccessToken()
    {
        $randomString = Uuid::uuid4()->toString() . time();
        return hash('sha512', $randomString);
    }

    private function generateRefreshToken()
    {
        $randomString = Uuid::uuid4()->toString() . time();
        return hash('sha512', $randomString);
    }

    private function getExpiresIn()
    {
        $time = time() + self::SIX_HOURS;
        return date("Y-m-d H:i:s", $time);
    }
}
