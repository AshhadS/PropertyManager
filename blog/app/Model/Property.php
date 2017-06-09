<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Property extends BaseModel{


	 /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'properties';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['propertyImage'];

    
    protected $primaryKey = 'PropertiesID';


    const CREATED_AT = 'createdDateTime';
    const UPDATED_AT = 'lastUpdatedDateTime';
}
