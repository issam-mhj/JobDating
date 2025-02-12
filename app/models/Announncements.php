<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announncements extends Model {


    use SoftDeletes;
    protected $table = 'announcements';
    protected $fillable = ['post_title', 'description', 'location', 'job_requirments','job_date', 'company_id'];

    
    public function company(){

        return $this->belongsTo(Company::class, 'company_id');

    }
}
