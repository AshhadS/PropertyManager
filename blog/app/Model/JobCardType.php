<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class JobCardType extends Model
{
    protected $table = 'jobcardtype';

    protected $primaryKey = 'jobcardTypeID';

    // Remove all timestamps
    public $timestamps = false;

}
