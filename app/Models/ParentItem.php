<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class ParentItem extends Model
{
    use HasFactory,SoftDeletes,Uuids;

    protected $fillable = [
        'unit_id',
        'category_id',
        'name',
        'image',
        'suplier',
        'harga',
    ];
}
