<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class JobCardComment extends Model
{
    protected $table = 'jobcardcomments';

    protected $primaryKey = 'commentID';

    // Remove all timestamps
    public $timestamps = false;

}
