<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CustomerInvoice extends Model
{
    protected $table = 'customerinvoice';

    protected $primaryKey = 'customerInvoiceID';

    const CREATED_AT = 'createdDateTime';
    const UPDATED_AT = 'lastUpdatedDateTime';
    
}
