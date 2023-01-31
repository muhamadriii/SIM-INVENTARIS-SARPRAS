<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends \Spatie\Permission\Models\Permission
{
    use Uuids, SoftDeletes;
    protected $keyType = 'string';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'guard_name',
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public static $rules = [
        'name'             => 'required|unique:groups,name',
        'description'      => 'required',
        // 'parent_id'        => 'required_if:category,==,1'
    ];
}
