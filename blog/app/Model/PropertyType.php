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

    public $timestamps = false;

}
