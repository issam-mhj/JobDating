<?php

namespace App\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Core\Controller;
use App\Core\View;
use App\Core\Session;
use App\Core\Logger;


class CompanyController extends Controller
{
    public function create()
    {
        return view::render('add_entreprise');
    }

    public function store($request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
        Company::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return view::render('/dashboard');
    }
}
