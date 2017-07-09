<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Supplier extends BaseModel{


	 /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'supplier';
    
    protected $primaryKey = 'supplierID';


    const CREATED_AT = 'createdDate';
    const UPDATED_AT = 'updatedDate';

   
}
