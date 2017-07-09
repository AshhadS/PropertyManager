<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'company';

    protected $primaryKey = 'companyID';

    
    public $timestamps = false;
}