<?php

namespace App\Core;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{

    public $guarded = ['id'];
    public $timestamp = true;
}
