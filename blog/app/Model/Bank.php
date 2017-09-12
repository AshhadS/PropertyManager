<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $table = 'bankmaster';

    protected $primaryKey = 'bankmasterID';

    // Remove all timestamps
    public $timestamps = false;
}
