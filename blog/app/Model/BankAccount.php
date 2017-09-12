<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $table = 'bankaccount';

    protected $primaryKey = 'bankAccountID';

    // Remove all timestamps
    public $timestamps = false;
}
