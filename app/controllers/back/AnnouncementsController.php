<?php
namespace App\Controllers\Back;
use App\Core\Controller;
use App\Core\View;
use App\Models\Announncements;
use App\Core\Validator;
use App\Core\Session;
use companies;

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
            $cover = $this->uploadCover($_FILES['cover']);

            
        
            Announncements::create([
                'post_title' => $data['title'],
                'description' => $data['description'],
                'location' => $data['location'],
                'cover' => $cover,
                'job_requirments' => $data['job_requirments'],
                'job_date' => $data['date'],
                'company_id' => $data['company_id']
            ]);

            Session::set('message', 'Announcement created successfully');

            $this->redirect('/Admin/Announcements?message=Announcement created successfully');
           
        }
        
    }

   
    public function uploadCover($file) {
        $file_name = $file['name'];
        $file_tmp_name = $file['tmp_name'];
        $file_error = $file['error'];

        if ($file_error === 0) {
            $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
            $file_extension_lowercase = strtolower($file_extension);
            $allowed_extensions = ['jpg', 'jpeg', 'png'];

            if (in_array($file_extension_lowercase, $allowed_extensions)) {
                $stored_file_name = time(). '_' . $file_name;
                $upload_directory = __DIR__.'/../../../public/assets/uploads/';

                // Ensure directory exists
                if (!file_exists($upload_directory)) {
                    mkdir($upload_directory, 0777, true);
                }

                $image_upload_path = $upload_directory . $stored_file_name;

                if (move_uploaded_file($file_tmp_name, $image_upload_path)) {
                    return $stored_file_name;
                }
            }
        }
        return false; 
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

            if ($_FILES['cover']['name'] === "") {
                $data['cover'] = $this->getCover($id);
            } else {
                $data['cover'] = $this->uploadCover($_FILES['cover']);
            }

            $announcement = Announncements::find($id);
            $announcement->post_title = $data['title'];
            $announcement->description = $data['description'];
            $announcement->location = $data['location'];
            $announcement->cover = $data['cover'];
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

    public function totalRecords() {
        return Announncements::all()->count();
      
    }


    public function getCover($id){
        $announcement = Announncements::find($id);
        return $announcement->cover;
    }
}