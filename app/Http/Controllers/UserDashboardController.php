<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class UserDashboardController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()
            ->latest()
            ->paginate(10);

        return view('user.dashboard', compact('orders'));
    }

    public function showOrder(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items.product');

        return view('user.order-show', compact('order'));
    }
}
