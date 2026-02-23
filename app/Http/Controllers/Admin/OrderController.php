<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
     // List all orders
    public function index()
    {
        $orders = Order::latest()->with('items.product')->get();
        return view('admin.orders.index', compact('orders'));
    }

    // View single order details
    public function show(Order $order)
    {
        $order->load('items.product');
        return view('admin.orders.show', compact('order'));
    }

    // Update order status (requires serial numbers when dispatching)
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,dispatched,completed,canceled',
        ]);

        if ($request->status === 'dispatched') {
            $order->load('items');

            $request->validate([
                'serial_numbers' => 'required|array',
                'serial_numbers.*' => 'required|string|max:255',
            ], [
                'serial_numbers.required' => 'Serial numbers are required when dispatching an order.',
                'serial_numbers.*.required' => 'Each item must have a serial number.',
            ]);

            foreach ($order->items as $item) {
                if (empty($request->serial_numbers[$item->id])) {
                    return back()->withErrors(['serial_numbers' => 'Serial number is required for every order item.'])->withInput();
                }
                $item->update(['serial_number' => $request->serial_numbers[$item->id]]);
            }
        }

        $order->update(['status' => $request->status]);

        return redirect()->route('admin.orders.show', $order->id)->with('success', 'Order #' . $order->id . ' status updated to ' . ucfirst($request->status));
    }
}