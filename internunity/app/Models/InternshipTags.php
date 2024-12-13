<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class InternshipTags extends Pivot
{
    protected $primaryKey = 'id'; // Or your custom primary key
    protected $keyType = 'string';
    public $incrementing = false;
}
