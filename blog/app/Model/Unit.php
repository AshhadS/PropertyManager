<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Unit extends BaseModel
{
    //
    	
    protected $table = 'units';

    protected $primaryKey = 'unitID';

    public $timestamps = false;

    public static function boot()
    {
        parent::boot();
    }
}
