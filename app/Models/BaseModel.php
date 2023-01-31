<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    use Uuids, SoftDeletes;
    protected $keyType = 'string';
    protected $primaryKey = 'id';
    public $incrementing = false;
}
