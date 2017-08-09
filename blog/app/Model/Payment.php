<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    protected $primaryKey = 'paymentID';

    
    const CREATED_AT = 'createdDateTime';
    const UPDATED_AT = 'lastUpdatedDateTime';
}
