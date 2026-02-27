<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
       protected $fillable = [
            'user_id',
             'name',
            'email',
            'phone',
            'address',
            'pincode',
            'state',
            'city',
            'gstin',
            'shipping_name',
            'shipping_phone',
            'shipping_address',
            'shipping_pincode',
            'shipping_state',
            'shipping_city',
            'total_amount',
            'coupon_id',
            'discount_amount',
            'subtotal',
            'gst_total',
            'shipping_amount',
            'shipping_gst',
            'payment_method',
            'payment_status',
            'payment_id',
            'invoice_number',
            'status',
    ];
    
    public function getHasSeparateShippingAttribute(): bool
    {
        return !empty($this->shipping_address);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
}
