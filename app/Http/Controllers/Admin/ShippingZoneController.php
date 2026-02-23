<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingZone;
use Illuminate\Http\Request;

class ShippingZoneController extends Controller
{
    public function index()
    {
        $zones = ShippingZone::latest()->get();
        return view('admin.shipping-zones.index', compact('zones'));
    }

    public function create()
    {
        $states = self::indianStates();
        return view('admin.shipping-zones.create', compact('states'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'states'     => 'required|array|min:1',
            'states.*'   => 'string',
            'rate'       => 'required|numeric|min:0',
            'free_above' => 'nullable|numeric|min:0',
            'status'     => 'required|boolean',
        ]);

        ShippingZone::create([
            'name'       => $request->name,
            'states'     => $request->states,
            'rate'       => $request->rate,
            'free_above' => $request->free_above,
            'status'     => $request->status,
        ]);

        return redirect()->route('admin.shipping-zones.index')
            ->with('success', 'Shipping zone created successfully');
    }

    public function edit(ShippingZone $shipping_zone)
    {
        $states = self::indianStates();
        return view('admin.shipping-zones.edit', compact('shipping_zone', 'states'));
    }

    public function update(Request $request, ShippingZone $shipping_zone)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'states'     => 'required|array|min:1',
            'states.*'   => 'string',
            'rate'       => 'required|numeric|min:0',
            'free_above' => 'nullable|numeric|min:0',
            'status'     => 'required|boolean',
        ]);

        $shipping_zone->update([
            'name'       => $request->name,
            'states'     => $request->states,
            'rate'       => $request->rate,
            'free_above' => $request->free_above,
            'status'     => $request->status,
        ]);

        return redirect()->route('admin.shipping-zones.index')
            ->with('success', 'Shipping zone updated successfully');
    }

    public function destroy(ShippingZone $shipping_zone)
    {
        $shipping_zone->delete();

        return redirect()->route('admin.shipping-zones.index')
            ->with('success', 'Shipping zone deleted successfully');
    }

    public static function indianStates(): array
    {
        return [
            'Andaman & Nicobar Islands',
            'Andhra Pradesh',
            'Arunachal Pradesh',
            'Assam',
            'Bihar',
            'Chandigarh',
            'Chhattisgarh',
            'Dadra & Nagar Haveli and Daman & Diu',
            'Delhi',
            'Goa',
            'Gujarat',
            'Haryana',
            'Himachal Pradesh',
            'Jammu & Kashmir',
            'Jharkhand',
            'Karnataka',
            'Kerala',
            'Ladakh',
            'Lakshadweep',
            'Madhya Pradesh',
            'Maharashtra',
            'Manipur',
            'Meghalaya',
            'Mizoram',
            'Nagaland',
            'Odisha',
            'Puducherry',
            'Punjab',
            'Rajasthan',
            'Sikkim',
            'Tamil Nadu',
            'Telangana',
            'Tripura',
            'Uttar Pradesh',
            'Uttarakhand',
            'West Bengal',
        ];
    }
}
