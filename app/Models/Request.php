<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class Request extends Model
{
    use HasFactory,SoftDeletes,Uuids;

    protected $fillable = [
        'name',
        'phone_number',
        'email',
        'necessity',
        'status',
        'created_by',
        'updated_by',
    ];
}
