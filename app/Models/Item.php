<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class Item extends Model
{
    use HasFactory,SoftDeletes,Uuids;

    protected $fillable = [
        'parent_id',
        'sku',
        'qr_code',
        'created_by',
        'updated_by',
    ];
}
