<?php

namespace App\Controllers\Front;

use App\Controllers\Back\CompanyController;
use App\Core\Controller;
use App\Core\Logger;
use App\Core\Session;
use App\Core\View;
use App\Models\User;
use App\Models\Announncements;

class UserController extends Controller
{
    public function index()
    {
        $usersNumber = count(User::get());
        $announncements = Announncements::with('company')->get();

        try {
            if (Session::isset('user_id') && $_SESSION['role'] == 'user') {
                View::render('UserDashboard', ['usersNumber' => $usersNumber, 'announncements' => $announncements]);
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
