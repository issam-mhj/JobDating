<?php

namespace App\Core;

use App\Models\User;

class Validator
{
    public static function validate($data, $rules)
    {
        $errors = [];
        foreach ($rules as $field => $rule) {
            if (!isset($data[$field])) {
                $errors[$field] = "Le champ $field est requis.";
            }
        }
        return $errors;
    }

    public static function sanitize($data) {
    
        if (is_array($data)) {
            return array_map([self::class, 'sanitize'], $data);
        }
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }

    public static function isValidPassword($password, $field, $errors = [])
    {
        if (!is_string($password)) {
            $errors[$field] = "The password must be a string.";
            return $errors;
        }

        if (strlen($password) < 8) {
            $errors[$field] = "The password must be at least 8 characters.";
            return $errors;
        }

        if (!preg_match("/[a-z]/", $password)) {
            $errors[$field] = "The password must contain at least one lowercase letter.";
            return $errors;
        }

        if (!preg_match("/[A-Z]/", $password)) {
            $errors[$field] = "The password must contain at least one uppercase letter.";
            return $errors;
        }

        if (!preg_match("/[0-9]/", $password)) {
            $errors[$field] = "The password must contain at least one number.";
            return $errors;
        }

        if (!preg_match("/[!@#$%^&*()_+-{};:'<>,.]/", $password)) {
            $errors[$field] = "The password must contain at least one special character.";
            return $errors;
        }

        return $errors;
    }

    public static function isValidEmail($email, $field, $errors = [])
    {
        if (!is_string($email)) {
            $errors[$field] = "The email must be a string.";
            return $errors;
        }

        if (empty($email)) {
            $errors[$field] = "The email field is required.";
            return $errors;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[$field] = "The email must be a valid email address.";
            return $errors;
        }

        return $errors;
    }

    public static function isEmailExists($email, $field, $errors = [])
    {
        $user = User::where('email', $email)->first();
        if ($user) {
            $errors[$field] = "The email address is already Exists.";
            return $errors;
        }
        return $errors;
    }

    public static function isValidUsername($username, $field, $errors = [])
    {
        if (!is_string($username)) {
            $errors[$field] = "The username must be a string.";
            return $errors;
        }

        if (empty($username)) {
            $errors[$field] = "The username field is required.";
            return $errors;
        }

        if (strlen($username) < 4) {
            $errors[$field] = "The username must be at least 4 characters long.";
            return $errors;
        }

        if (strlen($username) > 20) {
            $errors[$field] = "The username must not exceed 20 characters.";
            return $errors;
        }

        if (!preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
            $errors[$field] = "The username can only contain letters, numbers, and underscores.";
            return $errors;
        }

        return $errors;
    }
}
