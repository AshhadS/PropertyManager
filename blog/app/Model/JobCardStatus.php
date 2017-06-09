<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class JobCardStatus extends Model
{
    protected $table = 'jobcardstatus';

    protected $primaryKey = 'jobcardStatusID';

    
    public $timestamp = false;
}
