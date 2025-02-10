<?php

namespace App\Controllers\Front;

use App\Core\Controller;
use App\Core\View;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $users = User::all();
        View::render('home', ['users' => $users]);
    }
}