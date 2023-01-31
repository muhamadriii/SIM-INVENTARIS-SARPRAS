<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class Unit extends Model
{
    use HasFactory,SoftDeletes,Uuids;

    protected $fillable = [
        'name',
        'code',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
}
