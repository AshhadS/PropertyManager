<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Property extends Model{


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
    protected $fillable = ['custom'];

    
    protected $primaryKey = 'PropertiesID';


    const CREATED_AT = 'createdDateTime';
    const UPDATED_AT = 'lastUpdatedDateTime';
}
