<?php

namespace App\Helper;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTToken {
    public static function createToken($userEmail, $userID): string{
        $key = env('JWT_KEY');
        $payload = [
            'iss'       => 'laravel-token',
            'iat'       => time(),
            'exp'       => time() + 60 * 60,
            'userEmail' => $userEmail,
            'userID'    => $userID,
        ];
        return JWT::encode($payload, $key, 'HS256');
    }

    public static function createTokenForSetPassword($userEmail): string{
        $key = env('JWT_KEY');
        $payload = [
            'iss'       => 'laravel-token',
            'iat'       => time(),
            'exp'       => time() + 60 * 10,
            'userEmail' => $userEmail,
            'userID'    => '0',
        ];
        return JWT::encode($payload, $key, 'HS256');
    }

    public static function VerifyToken($token): string | object {
        try {
            if ($token == null) {
                return 'unauthorized';
            } else {
                $key = env('JWT_KEY');
                $decode = JWT::decode($token, new Key($key, "HS256"));
                return $decode;
            }
        } catch (Exception $e) {
            return 'unauthorized';
        }
    }

}