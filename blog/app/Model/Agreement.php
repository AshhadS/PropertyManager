<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Agreement extends BaseModel
{
    protected $table = 'agreement';

    protected $primaryKey = 'agreementID';

    
    const CREATED_AT = 'createdDateTime';
    const UPDATED_AT = 'lastUpdatedDateTime';
}
