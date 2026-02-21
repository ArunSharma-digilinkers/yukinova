<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
          $coupons = Coupon::latest()->get();
        return view('admin.coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([
            'code'             => 'required|string|unique:coupons,code',
            'type'             => 'required|in:flat,percentage',
            'value'            => 'required|numeric|min:0',
            'max_discount'     => 'nullable|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_uses'         => 'required|integer|min:1',
            'expires_at'       => 'required|date|after_or_equal:today',
            'status'           => 'required|in:active,inactive',
        ]);

        Coupon::create([
            'code'             => strtoupper($request->code),
            'type'             => $request->type,
            'value'            => $request->value,
            'max_discount'     => $request->max_discount,
            'min_order_amount' => $request->min_order_amount,
            'max_uses'         => $request->max_uses,
            'expires_at'       => $request->expires_at,
            'status'           => $request->status,
        ]);

        return redirect()->route('coupons.index')
            ->with('success', 'Coupon created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'code'             => 'required|string|unique:coupons,code,' . $coupon->id,
            'type'             => 'required|in:flat,percentage',
            'value'            => 'required|numeric|min:0',
            'max_discount'     => 'nullable|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_uses'         => 'required|integer|min:1',
            'expires_at'       => 'required|date',
            'status'           => 'required|in:active,inactive',
        ]);

        $coupon->update([
            'code'             => strtoupper($request->code),
            'type'             => $request->type,
            'value'            => $request->value,
            'max_discount'     => $request->max_discount,
            'min_order_amount' => $request->min_order_amount,
            'max_uses'         => $request->max_uses,
            'expires_at'       => $request->expires_at,
            'status'           => $request->status,
        ]);

        return redirect()->route('coupons.index')
            ->with('success', 'Coupon updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return redirect()->route('coupons.index')
            ->with('success', 'Coupon deleted successfully');
    }
}
