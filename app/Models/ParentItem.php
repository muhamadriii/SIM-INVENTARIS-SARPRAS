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
        'image',
        'name',
        'suplier',
        'stock',
        'price',
        'description',
    ];

    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }

}
