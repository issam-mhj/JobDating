<?php
namespace App\Controllers\Back;
use App\Core\Controller;
use App\Core\View;
use App\Models\Announncements;

class AnnouncementsController extends Controller {

   
    public function index() {

        $announncements = Announncements::with('company')->get();
        // $companies = (new CompanyController())->getAll();

        return view::render('announcements', ['announncements' => $announncements]);
    }

 
    public function create() {

        Announncements::create([
            'title' => 'New Announcement 2',
            'description' => 'This is a new announcement 2',
            'location' => 'Cairo - Egypt',
            'job_requirments' => 'PHP, Laravel, MySQL, HTML, CSS, JS',
            'company_id' => 5,
        ]);
        echo 'Announcement created successfully';

    }

    public function findById($id) {
        
        $announcement = Announncements::find($id);
        

    }

    public function update($id) {
        $announcement = Announncements::find($id);
        $announcement->title = 'Updated Announcement';
        $announcement->description = 'This is an updated announcement';
        $announcement->location = 'Giza - Egypt - Remote';
        $announcement->job_requirments = 'PHP, Laravel, MySQL, HTML, CSS, JS, React';
        $announcement->company_id = 5;
        $announcement->save();
        echo 'Announcement updated successfully';
    }

    public function delete($id) {
        $announcement = Announncements::find($id)->delete();
        echo 'Announcement deleted successfully';
    }

    public function restore($id) {
        $announcement = Announncements::withTrashed()->find($id)->restore();
        echo 'Announcement restored successfully';
    }

    public function totalRecords() {
        $total = Announncements::all()->count();
        echo 'Total Announcements: ' . $total;
    }
}