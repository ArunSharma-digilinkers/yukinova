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

    public static function generateInvoiceNumber(): string
    {
        $prefix = config('invoice.prefix', 'EVF');

        // Financial year: Apr 2025 - Mar 2026 = "2526"
        $now = now();
        if ($now->month >= 4) {
            $fyStart = $now->year;
            $fyEnd = $now->year + 1;
        } else {
            $fyStart = $now->year - 1;
            $fyEnd = $now->year;
        }
        $fyCode = substr($fyStart, 2) . substr($fyEnd, 2);

        // FY start/end dates for query
        $fyStartDate = $fyStart . '-04-01';
        $fyEndDate = $fyEnd . '-03-31 23:59:59';

        $lastOrder = static::whereBetween('created_at', [$fyStartDate, $fyEndDate])
            ->whereNotNull('invoice_number')
            ->orderByRaw('CAST(SUBSTRING_INDEX(invoice_number, "-", -1) AS UNSIGNED) DESC')
            ->first();

        $nextNum = $lastOrder
            ? ((int) substr($lastOrder->invoice_number, -5)) + 1
            : 1;

        return $prefix . '-' . $fyCode . '-' . str_pad($nextNum, 5, '0', STR_PAD_LEFT);
    }

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
