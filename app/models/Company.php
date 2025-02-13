<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Announncements;
class Company extends Model
{
    protected $table = 'companies';
    protected $fillable = ['company_name', 'email', 'number', 'location', 'logo', 'details'];


    public function announcements()
    {
        return $this->hasMany(Announncements::class);
    }

}
