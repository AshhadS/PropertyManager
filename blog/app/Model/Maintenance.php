<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends BaseModel{


	 /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jobcardmaintenance';

    
    protected $primaryKey = 'itemID';

    const CREATED_AT = 'createdDateTime';
    const UPDATED_AT = 'lastUpdatedDateTime';
}
