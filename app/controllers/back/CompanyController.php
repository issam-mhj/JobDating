<?php

namespace App\Controllers\Back;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Core\Controller;
use App\Core\View;
use Carbon\Carbon;
use App\Core\Session;
use App\Core\Logger;


class CompanyController extends Controller
{

    public function create()
    {
        return view::render('add_entreprise');
    }
    
    public function store()
    {
        $name = $_POST["name"];
        $details = $_POST["details"];
        Company::create([
            'company_name' => $name,
            'details' => $details,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return view::render('/AdminDashboard');
    }
    public function getAll(){
        
        $companies = Company::all();
        return $companies;
    }
}
