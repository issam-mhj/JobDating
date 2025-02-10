<?php
namespace App\Core;

use App\Models\User;
use App\Core\Security;

class Auth {
    public static function login($email, $password) {

        $user = User::where('email', $email)->first();
        if ($user && Security::verifyPassword($password, $user->password)) {
            session_regenerate_id(true);
            Session::set('user_id', $user->id);
            Session::set('role', $user->role);
            return true;
        }
        return false;
    }

    public static function logout() {
        Session::destroy();
        Session::delete('user_id');
        Session::delete('role');
    }

    public static function isAuthenticated() {
        Session::isset('user_id');
    }

    public static function getUser() {
        return self::isAuthenticated() ? User::find(Session::get('user_id')) : null;
    }

    public static function hasRole($role) {
        return Session::isset('role') && $_SESSION['role'] === $role;
    }

}