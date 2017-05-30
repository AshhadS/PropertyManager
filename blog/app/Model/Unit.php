<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Unit extends BaseModel
{
    //
    	
    protected $table = 'units';

    protected $primaryKey = 'unitID';

    const CREATED_AT = 'createdDateTime';
    const UPDATED_AT = 'lastUpdatedDateTime';

    public static function boot()
    {
        parent::boot();
    }
}
