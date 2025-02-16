<?php

namespace App\Controllers\Back;

use App\Models\Company;
use App\Models\Announncements;
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
        $email = $_POST["email"];
        $tel = $_POST["tel"];
        $location = $_POST["location"];
        if (isset($_FILES["logo"]) && $_FILES["logo"]["error"] === UPLOAD_ERR_OK) {
            $logoName = $_FILES["logo"]["name"];
            $logoTmpPath = $_FILES["logo"]["tmp_name"];
            $logoPath = 'assets/uploads/' . $logoName;
            move_uploaded_file($logoTmpPath, $logoPath);
        } else {
            $logoPath = null;
        }
        Company::create([
            'company_name' => $name,
            'email' => $email,
            'number' => $tel,
            'location' => $location,
            'logo' => $logoPath,
            'details' => $details,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        return view::render('/AdminDashboard');
    }
    public function getAll()
    {
        $companies = Company::withCount('announcements')->get();
        return $companies;
    }
    public function companies()
    {
        try {
            if (Session::isset('user_id') && $_SESSION['role'] === 'admin') {
                $currentUrl = $_SERVER['REQUEST_URI'];
                $companies = $this->getAll();
                View::render('companies', ["companies" => $companies, "currentUrl" => $currentUrl]);
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
        $location = $_POST["location"];
        $number = $_POST["number"];
        $email = $_POST["email"];
        if (isset($_FILES["logo"]) && $_FILES["logo"]["error"] <= 1) {
            $logoName = $_FILES["logo"]["name"];
            $logoTmpPath = $_FILES["logo"]["tmp_name"];
            $logoPath = 'assets/uploads/' . $logoName;
            move_uploaded_file($logoTmpPath, $logoPath);
        } else {
            $logoPath = Company::find($id)->logo;
        }
        Company::where('id', $id)->update(['company_name' => $name, 'email' => $email, 'number' => $number, 'location' => $location, 'logo' => $logoPath, 'details' => $details]);
        $this->redirect('/Admin/Companies');
    }

    public static function totalRecords()

    {
        return Company::all()->count();
    }

    public static function getCompanyName($company_id)
    {
        return Company::find($company_id)->company_name;
    }
}
