<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;

class LoanDetail extends Model
{
    use HasFactory,SoftDeletes,Uuids;

    protected $fillable = [
        'loan_id',
        'sku_item',
        'return_date',
        'status',
        'created_by',
        'updated_by',
    ];
}
