<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Data extends EloquentModel
{
    protected $connection = 'mysql';

    public $timestamps = false;
}

