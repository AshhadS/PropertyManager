<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class JobCardPriority extends Model
{
    protected $table = 'jobcardpriority';

    protected $primaryKey = 'priorityID';

    // Remove all timestamps
    public $timestamps = false;

}
