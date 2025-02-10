<?php

namespace App\Core;

class Security
{
    public static function generateCsrfToken()
    {
        if (empty(Session::get('csrf_token'))) {
            Session::set('csrf_token', bin2hex(random_bytes(32)));
        }
        Session::get('csrf_token');
    }

    public static function verifyCsrfToken($token)
    {
        return hash_equals(Session::get('csrf_token'), $token);
    }

    public static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function verifyPassword($password, $hashedPassword)
    {
        return password_verify($password, $hashedPassword);
    }
}