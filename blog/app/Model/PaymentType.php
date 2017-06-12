<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    protected $table = 'paymenttype';

    protected $primaryKey = 'paymentTypeID';

    public $timestamp = false;
    
}
