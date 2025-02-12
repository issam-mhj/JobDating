<?php
namespace App\Controllers\Back;
use App\Core\Controller;
use App\Core\View;
use App\Models\Announncements;
use App\Core\Validator;
use companies;

class AnnouncementsController extends Controller {

   
    public function index() {
        
        $announncements = Announncements::with('company')->get()->toArray();
        
        
        $companies = (new CompanyController())->getAll();

        return view::render('announcements', ['announncements' => $announncements, 'companies' => $companies]);
    }

 
    public function create() {

        if ($this->isPost()){
      
         
            $data = Validator::sanitize($_POST); 
        
            Announncements::create([
                'post_title' => $data['title'],
                'description' => $data['description'],
                'location' => $data['location'],
                'job_requirments' => $data['job_requirments'],
                'job_date' => $data['date'],
                'company_id' => $data['company_id']
            ]);

            $this->redirect('/Admin/Announcements?success=Announcement created successfully');
        
        }
        
    }


    public function showEditForm() {

        $id = $_GET['id'];
        $announcement = Announncements::find($id);
        $companies = (new CompanyController())->getAll();
        return view::render('edit_announce', ['announcement' => $announcement, 'companies' => $companies]);
    }

    public function updateAnnounce(){

        if ($this->isPost()){
            
            $data = Validator::sanitize($_POST); 
            $id = $data['id'];

            $announcement = Announncements::find($id);
            $announcement->post_title = $data['title'];
            $announcement->description = $data['description'];
            $announcement->location = $data['location'];
            $announcement->job_requirments = $data['job_requirments'];
            $announcement->job_date = $data['date'];
            $announcement->company_id = $data['company_id'];
            $announcement->save();
            
            $this->redirect('/Admin/Announcements?success=Announcement updated successfully');
        }

    }

    public function deleteAnnounce(){
  
        $id = Validator::sanitize($_GET['id']); 
        Announncements::find($id)->delete();
        $this->redirect('/Admin/Announcements?success=Announcement deleted successfully');

    }

   
    public function restore() {
        $id = Validator::sanitize($_GET['id']);
        return Announncements::withTrashed()->find($id)->restore();
    }

    public function totalRecords() {
        return Announncements::all()->count();
      
    }
}