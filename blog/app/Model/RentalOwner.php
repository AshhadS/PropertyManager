<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RentalOwner extends Model
{
    protected $table = 'rentalowners';

    protected $primaryKey = 'rentalownerID';

    
    const CREATED_AT = 'createdDateTime';
    const UPDATED_AT = 'lastUpdatedDateTime';
}
