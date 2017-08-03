<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SupplierInvoice extends Model
{
    protected $table = 'supplierinvoice';

    protected $primaryKey = 'supplierInvoiceID';

    const CREATED_AT = 'createdDateTime';
    const UPDATED_AT = 'lastUpdatedDateTime';
    
}
