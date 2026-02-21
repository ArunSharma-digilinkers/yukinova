<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'price',
        'sale_price',
        'gst_percentage',
        'gst_type',
        'shipping_type',
        'shipping_rate',
        'short_description',
        'technical_features',
        'warranty',
        'quantity',
        'description',
        'status',
        'is_new_arrival',
        'image',
        'images',
        'hsn_code'
    ];

     protected $casts = [
        'images' => 'array',
    ];

    public function getBasePriceAttribute()
    {
        if ($this->gst_type === 'inclusive' && $this->gst_percentage > 0) {
            return round($this->price / (1 + $this->gst_percentage / 100), 2);
        }
        return $this->price;
    }

    public function getGstAmountAttribute()
    {
        if ($this->gst_percentage > 0) {
            return round($this->base_price * $this->gst_percentage / 100, 2);
        }
        return 0;
    }

    public function getTotalPriceAttribute()
    {
        if ($this->gst_type === 'extra') {
            return round($this->price + $this->gst_amount, 2);
        }
        return $this->price;
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function addons()
    {
        return $this->belongsToMany(Product::class, 'product_addon', 'product_id', 'addon_id');
    }

}
