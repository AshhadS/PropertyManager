<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ImageFile extends Model
{
    protected $table = 'imageFiles';
    protected $primaryKey = 'fileID';
    
    public $timestamps = false;    
}
