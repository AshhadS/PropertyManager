<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Reconciliation extends Model
{
    protected $table = 'bankreconciliationmaster';

    protected $primaryKey = 'bankReconciliationMasterID';

    // Remove all timestamps
    public $timestamps = false;
}
