<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
    use HasFactory,Uuids,SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'unit_id',
        'name',
        'description',
        'short_description',
        'sku',
        'price',
        'discount',
        'stock',
    ];

    protected $appends = [
        'rating',
        'rating_total'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function productImage()
    {
        return $this->hasOne(ProductImage::class);
    }
    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'id');

    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function getRatingAttribute() {
        // $avarage_rating = 0;
        // if (count($this->ratings) > 0) {
        //     $avarage_rating  = $this->ratings->sum('rating') / count($this->ratings);
        // }
        // return $avarage_rating;
        return 10;
    }

    public function getRatingTotalAttribute() {
        // $rating = 0;
        // if (count($this->ratings) > 0) {
        // }
        // $rating = count($this->ratings);
        // return $rating;
        return 2;
    }
}
