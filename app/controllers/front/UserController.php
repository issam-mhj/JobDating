<?php

namespace App\Controllers\Front;

use App\Core\Controller;
use App\Core\Logger;
use App\Core\Session;
use App\Core\View;
use App\Models\Company;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $usersNumber = count(User::get());
        
        try {
            if (Session::isset('user_id') && $_SESSION['role'] == 'user') {
                $companies = Company::all();
                View::render('UserDashboard', ['usersNumber' => $usersNumber, 'companies' => $companies]);
            } else {
                $this->redirect('/login');
            }
        } catch (\Exception $e) {
            Logger::setLogLevel('error');
            Logger::error($e->getMessage());
            View::render('login', ['webError' => 'An error occurred, please try again']);
        }
    }
}
