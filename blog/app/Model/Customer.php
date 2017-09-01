<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Customer extends BaseModel{


	 /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customer';
    
    protected $primaryKey = 'customerID';


    const CREATED_AT = 'createdDate';
    const UPDATED_AT = 'updatedDate';

   
}
