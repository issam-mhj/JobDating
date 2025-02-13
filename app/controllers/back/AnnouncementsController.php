<?php
namespace App\Controllers\Back;
use App\Core\Controller;
use App\Core\View;
use App\Models\Announncements;
use App\Core\Validator;
use App\Core\Session;

class AnnouncementsController extends Controller {
    
    
    public function index() {

        Session::delete('message');
        
        $currentUrl = $_SERVER['REQUEST_URI'];
        $announncements = Announncements::with('company')->get();
        $companies = (new CompanyController())->getAll();
        return view::render('announcements', ['announncements' => $announncements, 'companies' => $companies, 'currentUrl' => $currentUrl, 'message' => '$this->message']);

    }

    public function deletedAnnounces() {
        Session::delete('message');
        $currentUrl = $_SERVER['REQUEST_URI'];
        $announncements = Announncements::onlyTrashed()->get();
        $companies = (new CompanyController())->getAll();
        return view::render('delete_announcements', ['announncements' => $announncements, 'companies' => $companies, 'currentUrl' => $currentUrl]);
    }

    public function hardDeleteAnnounce() {
        $id = Validator::sanitize($_GET['id']);
        Announncements::withTrashed()->find($id)->forceDelete();
        Session::set('message', 'Announcement deleted permanently');
        $this->redirect('/Admin/Announcements/deleted?success=Announcement deleted permanently');
    
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

            Session::set('message', 'Announcement created successfully');

            $this->redirect('/Admin/Announcements?message=Announcement created successfully');
           
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

            Session::set('message', 'Announcement updated successfully');
            
            $this->redirect('/Admin/Announcements?message=Announcement_updated_successfully');
        }

    }

    public function deleteAnnounce(){
  
        $id = Validator::sanitize($_GET['id']); 
        Announncements::find($id)->delete();
        Session::set('message', 'Announcement deleted successfully');
        $this->redirect('/Admin/Announcements?message=Announcement_deleted_successfully');

    }

   
    public function restore() {
        $id = Validator::sanitize($_GET['id']);
        Announncements::withTrashed()->find($id)->restore();
        Session::set('message', 'Announcement restored successfully');
        $this->redirect('/Admin/Announcements/deleted?message=Announcement_restored_successfully');
    }

    public static function totalRecords() {
        return Announncements::all()->count();
      
    }
}