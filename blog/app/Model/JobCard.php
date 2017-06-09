<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class JobCard extends BaseModel
{
    protected $table = 'jobcard';

    protected $primaryKey = 'jobcardID';

    
    const CREATED_AT = 'createdDateTime';
    const UPDATED_AT = 'lastUpdatedDateTime';
}
