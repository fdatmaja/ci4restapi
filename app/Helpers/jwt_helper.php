<?php

use App\Models\ModelOtentikasi;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function getJWT($otentikasiHeader)
{
    if (is_null($otentikasiHeader)) {
        throw new Exception("Otentikasi JWT Gagal");
    } else {
        return explode(" ", $otentikasiHeader)[1];
    }
}

function validateJWT($encodedToken)
{
    $key = getenv('JWT_SECRET_KEY');
    $decodedToken = JWT::decode($encodedToken, new Key($key, 'HS256'));
    $modelOtentikasi = new ModelOtentikasi();
    //xxxx.xxxx.xxxx
    $modelOtentikasi->getEmail($decodedToken->email);
}

function createJWT($email)
{
    $key = getenv('JWT_SECRET_KEY');
    $waktuRequest = time();
    $waktuToken = getenv('JWT_TIME_TO_LIVE');
    $waktuExpired = $waktuRequest + $waktuToken;

    $payload = [
        'email' => $email,
        'iat' => $waktuRequest,
        'exp' => $waktuExpired
    ];

    $jwt = JWT::encode($payload, $key, 'HS256');
    return $jwt;
}

function decryptJWT($encodedToken)
{
    $key = getenv('JWT_SECRET_KEY');
    $decodedToken = JWT::decode($encodedToken, new Key($key, 'HS256'));
    return $decodedToken;
}
