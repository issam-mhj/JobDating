<?php

namespace App\Controllers\Back;

use App\Core\Controller;
use App\Core\Session;
use App\Core\View;
use App\Core\Logger;
use App\Models\User;


class AdminController extends Controller
{
    public function index()
    {
        try {
            if (Session::isset('user_id') && $_SESSION['role'] === 'admin') {
                $user = User::find(Session::get('user_id'));
                $currentUrl = $_SERVER['REQUEST_URI'];
                View::render('AdminDashboard', ['user' => $user, 'currentUrl' => $currentUrl]);
            } else {
                $this->redirect('/login');
            }
        } catch (\Exception $e) {

            Logger::setLogLevel('error');
            Logger::error($e->getMessage());
            View::render('login', ['webError' => 'An error occurred, please try again']);
        }
    }
    // public function announce()
    // {
    //     try {
    //         if (Session::isset('user_id') && $_SESSION['role'] === 'admin') {
    //             // $user = User::find(Session::get('user_id'));
    //             View::render('announcements');
    //         } else {
    //             $this->redirect('/login');
    //         }
    //     } catch (\Exception $e) {
    //         Logger::setLogLevel('error');
    //         Logger::error($e->getMessage());
    //         View::render('login', ['webError' => 'An error occurred, please try again']);
    //     }
    // }
    // public function companies()
    // {
    //     try {
    //         if (Session::isset('user_id') && $_SESSION['role'] === 'admin') {
                
    //     $current_uri = $_SERVER['REQUEST_URI'];
    //             // $user = User::find(Session::get('user_id'));
    //             View::render('companies', ['current_uri' => $current_uri]);
    //         } else {
    //             $this->redirect('/login');
    //         }
    //     } catch (\Exception $e) {
    //         Logger::setLogLevel('error');
    //         Logger::error($e->getMessage());
    //         View::render('login', ['webError' => 'An error occurred, please try again']);
    //     }
    // }
}
