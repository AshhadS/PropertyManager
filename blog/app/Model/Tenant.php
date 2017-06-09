<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tenant extends BaseModel
{
    protected $table = 'tenants';

    protected $primaryKey = 'tenantsID';

    
    const CREATED_AT = 'createdDateTime';
    const UPDATED_AT = 'lastUpdatedDateTime';
}
