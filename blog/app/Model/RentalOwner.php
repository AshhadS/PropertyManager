<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RentalOwner extends BaseModel
{
    protected $table = 'rentalowners';

    protected $primaryKey = 'rentalOwnerID';

    
    const CREATED_AT = 'createdDateTime';
    const UPDATED_AT = 'lastUpdatedDateTime';
}
