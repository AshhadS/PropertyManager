<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class JobcardReceipt extends Model
{
    protected $table = 'receipt';

    protected $primaryKey = 'receiptID';

    
    const CREATED_AT = 'createdDateTime';
    const UPDATED_AT = 'lastUpdatedDateTime';
}
