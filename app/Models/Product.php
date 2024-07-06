<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_name',
        'product_price',
        'product_description',
        'product_images',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

     public function product_images()
    {
        return $this->hasMany(ProductImage::class);
    }
    protected $casts = [
        'product_images' => 'array',
    ];
}
