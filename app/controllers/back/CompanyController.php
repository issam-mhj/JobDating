<?php

namespace App\Controllers\Back;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Core\Controller;
use App\Core\View;
use Carbon\Carbon;
use App\Core\Session;
use App\Core\Logger;
use App\Models\User;

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
    public function getAll()
    {

        $companies = Company::all();
        return $companies;
    }
    public function companies()
    {
        try {
            if (Session::isset('user_id') && $_SESSION['role'] === 'admin') {
                // $user = User::find(Session::get('user_id'));
                $companies = $this->getAll();
                View::render('companies', ["companies" => $companies]);
            } else {
                $this->redirect('/login');
            }
        } catch (\Exception $e) {
            Logger::setLogLevel('error');
            Logger::error($e->getMessage());
            View::render('login', ['webError' => 'An error occurred, please try again']);
        }
    }
    public function deleteCompany()
    {
        $id = $_GET["id"];
        Company::find($id)->delete();
        $this->redirect('/Admin/Companies');
    }
    public function showModify()
    {
        $id = $_GET["id"];
        $company = company::find($id);
        return view::render('editCompany', ["company" => $company]);
    }
    public function modifyCompany()
    {
        $id = $_POST["company_id"];
        $name = $_POST["company_name"];
        $details = $_POST["details"];
        Company::where('id', $id)->update(['company_name' => $name, 'details' => $details]);
        $this->redirect('/Admin/Companies');
    }
}
