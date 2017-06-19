<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class JobCardLog extends Model
{
    protected $table = 'jobcardlog';

    protected $primaryKey = 'jobCardLogID';

    // Remove all timestamps
    public $timestamps = false;

}
