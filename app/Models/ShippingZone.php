<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingZone extends Model
{
    protected $fillable = [
        'name',
        'states',
        'rate',
        'free_above',
        'status',
    ];

    protected $casts = [
        'states' => 'array',
        'rate' => 'decimal:2',
        'free_above' => 'decimal:2',
        'status' => 'boolean',
    ];

    public static function getShippingCost(string $state, float $subtotal, array $cartProducts): array
    {
        $hasZoneProduct = false;
        $productShipping = 0;

        foreach ($cartProducts as $cp) {
            if ($cp['product']->shipping_type === 'zone') {
                $hasZoneProduct = true;
                $productShipping += $cp['product']->shipping_rate * $cp['quantity'];
            }
        }

        if (!$hasZoneProduct) {
            return ['shipping' => 0, 'free' => true];
        }

        $zone = static::where('status', true)
            ->whereJsonContains('states', $state)
            ->first();

        if (!$zone) {
            return ['shipping' => 0, 'free' => false, 'error' => 'Shipping is not available for your state.'];
        }

        if ($zone->free_above && $subtotal >= $zone->free_above) {
            return ['shipping' => 0, 'free' => true];
        }

        $totalShipping = round($productShipping * (float) $zone->rate, 2);

        return ['shipping' => $totalShipping, 'free' => false];
    }
}
