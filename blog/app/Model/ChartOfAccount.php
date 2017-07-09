<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ChartOfAccount extends Model
{
    protected $table = 'chartofaccounts';

    protected $primaryKey = 'chartOfAccountID';

    
    public $timestamps = false;
}
