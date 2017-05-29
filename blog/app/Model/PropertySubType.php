<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PropertySubType extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'propertysubtypeid';

    protected $primaryKey = 'propertySubTypeID';

    public function propertyType(){
        return $this->hasOne('App\PropertyType', 'propertyTypeID');
    }
}
