<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
     protected $fillable = [
        'code',
        'type',
        'value',
        'max_discount',
        'min_order_amount',
        'max_uses',
        'used_count',
        'expires_at',
        'status',
    ];

     protected $casts = [
        'expires_at' => 'date',
    ];

    public function isValid($orderTotal = 0)
    {
        if ($this->status !== 'active') {
            return false;
        }
        if ($this->expires_at->lt(now()->startOfDay())) {
            return false;
        }
        if ($this->used_count >= $this->max_uses) {
            return false;
        }
        if ($this->min_order_amount && $orderTotal < $this->min_order_amount) {
            return false;
        }
        return true;
    }

     public function calculateDiscount($orderTotal)
    {
        if ($this->type === 'percentage') {
            $discount = $orderTotal * $this->value / 100;
            if ($this->max_discount) {
                $discount = min($discount, $this->max_discount);
            }
            return round($discount, 2);
        }

        return round(min($this->value, $orderTotal), 2);
    }
}
