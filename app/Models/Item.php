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
        'color',
        'count_print',
        'status',
        'created_by',
        'updated_by',
    ];

    public function parent()
    {
        return $this->belongsTo(ParentItem::class, 'parent_id', 'id');
    }
}
