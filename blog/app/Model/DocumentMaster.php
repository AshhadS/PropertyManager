<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DocumentMaster extends Model
{
    protected $table = 'documentmaster';

    protected $primaryKey = 'documentID';

    
    public $timestamp = false;
}
