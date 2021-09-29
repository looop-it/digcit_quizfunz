<?php

namespace App\Utilities;

use Firebase\JWT\JWT;

class JWTEncrypt
{
    public function __construct()
    {
        if (config('sso.access_key') === null || config('sso.access_secret') === null) {
            throw new \Exception("SSO Credentials are not configured", 500);
        }

        $this->accessKey = config('sso.access_key');
        $this->accessSecret = config('sso.access_secret');
    }

    /**
     * Encrypt payload
     *
     * @param array $payload
     * @return string
     */
    public function encrypt(array $payload, string $algorithm = 'HS256') : string
    {
        return JWT::encode(array_merge(
            $payload,
            [
                'iat' => now()->timestamp
            ]
        ), $this->getEncryptKey(), $algorithm);
    }

    private function getEncryptKey()
    {
        return $this->accessKey.$this->accessSecret;
    }
}
