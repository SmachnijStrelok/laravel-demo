<?php

namespace App\Services;

use Firebase\JWT\JWT;

class JWTDecoder {

    public function decode($token)
    {
        $pubKey = $this->getPublicKey();
        return JWT::decode($token, $pubKey, ['HS256', 'HS384', 'HS512', 'RS256']);
    }

    public function encode($payload, $header)
    {
        throw new \Exception('Not implemented');
    }

    protected function getPublicKey() {
        exec('openssl x509 -pubkey -noout -in /etc/letsencrypt/cert.pem', $output);
        return implode("\n", $output);
    }

    protected function getPrivateKey() {
        return file_get_contents('/etc/letsencrypt/privkey.pem');
    }

}
