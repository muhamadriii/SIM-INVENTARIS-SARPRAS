<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class RequestDetail extends Model
{
    use HasFactory,SoftDeletes,Uuids;

    protected $fillable = [
        'request_id',
        'sku_item',
        'created_by',
        'updated_by',
    ];
}
