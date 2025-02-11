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
            'company_name' => 'required|string|max:255',
            'details' => 'required|string',

        ]);
        Company::create([
            'company_name' => $request->name,
            'details' => $request->description,
        ]);

        return view::render('/dashboard');
    }
}
