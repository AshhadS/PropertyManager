<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $table = 'attachments';

    protected $primaryKey = 'attachmentID';

    
    const CREATED_AT = 'uploadedDateTime';
    const UPDATED_AT = 'updatedDateTime';
}
