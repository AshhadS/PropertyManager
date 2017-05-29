<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class BaseModel extends Eloquent
{
    public static function boot()
    {
        parent::boot();
        static::creating(function($model)
        {
            $user = Sentinel::getUser();
            $model->createdByUserID = $user->id;
        });
        static::updating(function($model)
        {
            $user = Sentinel::getUser();
            $model->lastUpdatedByUserID = $user->id;
        });
    }

}
