<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PropertyType extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'propertytype';

    protected $primaryKey = 'propertyTypeID';

    public $timestamp = false;

    public function propertySubTypeID(){
	    return $this->belongsTo('App\PropertySubType', 'propertySubTypeID');
	}
}
