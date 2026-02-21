<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\User;
use App\Models\Address;
use App\Models\ShippingZone;
use App\Models\AbandonedCheckout;
use App\Mail\OrderConfirmation;
use App\Mail\NewOrderAdmin;
use App\Mail\WelcomeNewUser;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        $coupon = null;
        $couponCode = session('coupon_code');
        if ($couponCode) {
            $coupon = Coupon::where('code', $couponCode)->first();
        }

        $summary = $this->calculateSummary($cart, $coupon);

        $addresses = collect();
        $defaultAddress = null;
        $userGstin = '';

        if (auth()->check()) {
            $addresses = auth()->user()->addresses()->latest()->get();
            $defaultAddress = auth()->user()->defaultAddress();
            $userGstin = auth()->user()->gstin ?? '';
        }

        return view('checkout.index', compact('cart', 'coupon', 'summary', 'addresses', 'defaultAddress', 'userGstin'));
    }

    public function applyCoupon(Request $request)
    {
        $code = strtoupper(trim($request->input('coupon_code', '')));

        if (!$code) {
            return response()->json(['success' => false, 'message' => 'Please enter a coupon code.']);
        }

        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Invalid coupon code.']);
        }

        $cart = session()->get('cart', []);
        $subtotal = 0;
        foreach ($cart as $slug => $item) {
            $product = Product::where('slug', $slug)->first();
            if ($product) {
                $subtotal += $product->base_price * $item['quantity'];
            }
        }

        if (!$coupon->isValid($subtotal)) {
            $message = 'Coupon is not valid.';
            if ($coupon->status !== 'active') {
                $message = 'This coupon is inactive.';
            } elseif ($coupon->expires_at->lt(now()->startOfDay())) {
                $message = 'This coupon has expired.';
            } elseif ($coupon->used_count >= $coupon->max_uses) {
                $message = 'This coupon has reached its usage limit.';
            } elseif ($coupon->min_order_amount && $subtotal < $coupon->min_order_amount) {
                $message = 'Minimum order of ₹' . number_format($coupon->min_order_amount, 2) . ' required.';
            }
            return response()->json(['success' => false, 'message' => $message]);
        }

        session(['coupon_code' => $coupon->code]);

        $summary = $this->calculateSummary($cart, $coupon);

        return response()->json([
            'success' => true,
            'message' => 'Coupon applied successfully!',
            'coupon' => [
                'code' => $coupon->code,
                'type' => $coupon->type,
                'value' => $coupon->value,
            ],
            'summary' => $summary,
        ]);
    }

    public function removeCoupon()
    {
        session()->forget('coupon_code');

        $cart = session()->get('cart', []);
        $summary = $this->calculateSummary($cart, null);

        return response()->json([
            'success' => true,
            'message' => 'Coupon removed.',
            'summary' => $summary,
        ]);
    }

    public function getShippingCost(Request $request)
    {
        $state = $request->query('state');
        if (!$state) {
            return response()->json(['shipping' => 0, 'free' => true, 'shipping_gst' => 0]);
        }

        $cart = session()->get('cart', []);
        $cartProducts = [];
        $subtotal = 0;
        $maxGstPercentage = 0;

        foreach ($cart as $slug => $item) {
            $product = Product::where('slug', $slug)->first();
            if (!$product) continue;

            $subtotal += $product->base_price * $item['quantity'];
            $cartProducts[] = ['product' => $product, 'quantity' => $item['quantity']];

            if ($product->gst_percentage > $maxGstPercentage) {
                $maxGstPercentage = $product->gst_percentage;
            }
        }

        $result = ShippingZone::getShippingCost($state, $subtotal, $cartProducts);

        // Calculate GST on shipping at the highest product GST rate
        $shippingGst = 0;
        if (!isset($result['error']) && $result['shipping'] > 0 && $maxGstPercentage > 0) {
            $shippingGst = round($result['shipping'] * $maxGstPercentage / 100, 2);
        }

        $result['shipping_gst'] = $shippingGst;

        return response()->json($result);
    }

    public function getAddress(Address $address)
    {
        if (auth()->id() !== $address->user_id) {
            abort(403);
        }

        return response()->json($address);
    }

    public function saveAbandonedCheckout(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return response()->json(['success' => false]);
        }

        $cartData = [];
        foreach ($cart as $slug => $item) {
            $cartData[] = [
                'name' => $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'image' => $item['image'] ?? null,
            ];
        }

        AbandonedCheckout::updateOrCreate(
            [
                'email' => $request->email,
                'recovered' => false,
            ],
            [
                'user_id' => auth()->id(),
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'pincode' => $request->pincode,
                'state' => $request->state,
                'city' => $request->city,
                'cart_data' => $cartData,
                'total_amount' => $request->total_amount ?? 0,
                'coupon_code' => session('coupon_code'),
            ]
        );

        return response()->json(['success' => true]);
    }

    public function placeOrder(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        $request->validate([
            'name'    => 'required|string|min:3',
            'email'   => 'required|email',
            'phone'   => 'required|digits:10',
            'pincode' => 'required|digits:6',
            'state'   => 'required|string',
            'city'    => 'required|string',
            'address' => 'required|min:10',
            'gstin'   => ['nullable', 'regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/'],
            'ship_to_different' => 'nullable|boolean',
            'shipping_name'    => 'required_if:ship_to_different,1|nullable|string|min:3',
            'shipping_phone'   => 'required_if:ship_to_different,1|nullable|digits:10',
            'shipping_pincode' => 'required_if:ship_to_different,1|nullable|digits:6',
            'shipping_state'   => 'required_if:ship_to_different,1|nullable|string',
            'shipping_city'    => 'required_if:ship_to_different,1|nullable|string',
            'shipping_address' => 'required_if:ship_to_different,1|nullable|min:10',
            'payment_method' => 'required|in:razorpay',
            'razorpay_payment_id' => 'required|string',
        ]);

        $coupon = null;
        $couponCode = session('coupon_code');
        if ($couponCode) {
            $coupon = Coupon::where('code', $couponCode)->first();
        }

        $summary = $this->calculateSummary($cart, $coupon);

        // Build cart products array for shipping calculation
        $cartProducts = [];
        foreach ($summary['items'] as $itemData) {
            $product = Product::find($itemData['product_id']);
            if ($product) {
                $cartProducts[] = ['product' => $product, 'quantity' => $itemData['quantity']];
            }
        }

        $shipToDifferent = (bool) $request->input('ship_to_different');
        $shippingState = $shipToDifferent ? $request->shipping_state : $request->state;

        $shippingResult = ShippingZone::getShippingCost($shippingState, $summary['subtotal'], $cartProducts);

        if (isset($shippingResult['error'])) {
            return redirect()->back()->with('error', $shippingResult['error']);
        }

        $shippingAmount = $shippingResult['shipping'];

        // Calculate GST on shipping at the highest product GST rate
        $shippingGst = 0;
        if ($shippingAmount > 0 && $summary['max_gst_percentage'] > 0) {
            $shippingGst = round($shippingAmount * $summary['max_gst_percentage'] / 100, 2);
        }

        // Consolidated GST = product GST + shipping GST
        $consolidatedGst = round($summary['gst_total'] + $shippingGst, 2);

        $summary['shipping'] = $shippingAmount;
        $summary['shipping_gst'] = $shippingGst;
        $summary['gst_total'] = $consolidatedGst;
        $summary['grand_total'] = round($summary['discounted_subtotal'] + $consolidatedGst + $shippingAmount);

        DB::beginTransaction();

        try {
            // Verify stock availability with row lock
            foreach ($summary['items'] as $itemData) {
                $product = Product::where('id', $itemData['product_id'])
                    ->lockForUpdate()
                    ->first();

                if (!$product || $product->quantity < $itemData['quantity']) {
                    DB::rollBack();
                    $availableQty = $product ? $product->quantity : 0;
                    return redirect()->back()
                        ->with('error', "{$itemData['name']} has only {$availableQty} left in stock.");
                }
            }

            // Verify Razorpay payment
            $api = new Api(
                config('services.razorpay.key'),
                config('services.razorpay.secret')
            );

            $payment = $api->payment->fetch($request->razorpay_payment_id);

            if (!in_array($payment->status, ['authorized', 'captured'])) {
                throw new \Exception('Payment not successful');
            }

            // Find or create user
            $isNewUser = false;
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'password' => Str::random(32),
                    'role' => 'user',
                    'status' => 1,
                ]);
                $isNewUser = true;
            }

            // Create Order
            $order = Order::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'pincode' => $request->pincode,
                'state' => $request->state,
                'city' => $request->city,
                'gstin' => $request->gstin ?: null,
                'shipping_name' => $shipToDifferent ? $request->shipping_name : null,
                'shipping_phone' => $shipToDifferent ? $request->shipping_phone : null,
                'shipping_address' => $shipToDifferent ? $request->shipping_address : null,
                'shipping_pincode' => $shipToDifferent ? $request->shipping_pincode : null,
                'shipping_state' => $shipToDifferent ? $request->shipping_state : null,
                'shipping_city' => $shipToDifferent ? $request->shipping_city : null,
                'total_amount' => $summary['grand_total'],
                'coupon_id' => $coupon?->id,
                'discount_amount' => $summary['discount'],
                'subtotal' => $summary['subtotal'],
                'gst_total' => $summary['gst_total'],
                'shipping_amount' => $summary['shipping'],
                'shipping_gst' => $summary['shipping_gst'],
                'payment_method' => 'razorpay',
                'payment_status' => 'paid',
                'payment_id' => $payment->id,
                'invoice_number' => Order::generateInvoiceNumber(),
            ]);

            // Save Order Items + Reduce Stock
            foreach ($summary['items'] as $itemData) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $itemData['product_id'],
                    'quantity' => $itemData['quantity'],
                    'price' => $itemData['price'],
                    'base_price' => $itemData['base_price'],
                    'gst_percentage' => $itemData['gst_percentage'],
                    'gst_amount' => $itemData['gst_amount'],
                    'discount_amount' => $itemData['discount_amount'],
                    'total_price' => $itemData['total_price'],
                ]);

                Product::where('id', $itemData['product_id'])
                    ->decrement('quantity', $itemData['quantity']);
            }

            // Increment coupon usage
            if ($coupon) {
                $coupon->increment('used_count');
            }

            // Save GSTIN to user profile
            if ($request->gstin) {
                $user->update(['gstin' => $request->gstin]);
            }

            // Save address for new users
            if ($isNewUser) {
                Address::create([
                    'user_id' => $user->id,
                    'label' => 'Billing',
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'pincode' => $request->pincode,
                    'state' => $request->state,
                    'city' => $request->city,
                    'is_default' => true,
                ]);

                if ($shipToDifferent) {
                    Address::create([
                        'user_id' => $user->id,
                        'label' => 'Shipping',
                        'name' => $request->shipping_name,
                        'phone' => $request->shipping_phone,
                        'address' => $request->shipping_address,
                        'pincode' => $request->shipping_pincode,
                        'state' => $request->shipping_state,
                        'city' => $request->shipping_city,
                        'is_default' => false,
                    ]);
                }
            }

            DB::commit();

            // Mark abandoned checkout as recovered
            AbandonedCheckout::where('email', $order->email)
                ->where('recovered', false)
                ->latest()
                ->first()
                ?->update(['recovered' => true, 'recovered_order_id' => $order->id]);

            // Send emails (outside transaction so failures don't break checkout)
            try {
                $order->load('items.product');

                Mail::to($order->email)->send(new OrderConfirmation($order));

                Mail::to(config('services.evfast.admin_email'))->send(new NewOrderAdmin($order));

                if ($isNewUser) {
                    $token = Password::createToken($user);
                    $resetUrl = url(route('password.reset', ['token' => $token, 'email' => $user->email], false));
                    Mail::to($user->email)->send(new WelcomeNewUser($user, $resetUrl));
                }
            } catch (\Exception $e) {
                // Log email failure but don't break checkout
                \Log::error('Order email failed: ' . $e->getMessage());
            }

            // Clear cart and coupon
            session()->forget(['cart', 'coupon_code']);

            return redirect()->route('payment.success', $order->id);

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }

    private function calculateSummary(array $cart, ?Coupon $coupon = null): array
    {
        $items = [];
        $subtotal = 0;
        $maxGstPercentage = 0;

        foreach ($cart as $slug => $item) {
            $product = Product::where('slug', $slug)->first();
            if (!$product) continue;

            $itemBasePrice = $product->base_price;
            $itemSubtotal = $itemBasePrice * $item['quantity'];
            $subtotal += $itemSubtotal;

            if ($product->gst_percentage > $maxGstPercentage) {
                $maxGstPercentage = $product->gst_percentage;
            }

            $items[$slug] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'quantity' => $item['quantity'],
                'price' => $product->price,
                'base_price' => $itemBasePrice,
                'gst_percentage' => $product->gst_percentage,
                'gst_type' => $product->gst_type,
                'item_subtotal' => $itemSubtotal,
            ];
        }

        // Calculate discount on base total
        $discount = 0;
        if ($coupon && $coupon->isValid($subtotal)) {
            $discount = $coupon->calculateDiscount($subtotal);
        }

        $discountedSubtotal = $subtotal - $discount;

        // Distribute discount proportionally and calculate GST per item
        $gstTotal = 0;
        foreach ($items as $slug => &$itemData) {
            $proportion = $subtotal > 0 ? $itemData['item_subtotal'] / $subtotal : 0;
            $itemDiscount = round($discount * $proportion, 2);
            $taxableValue = $itemData['item_subtotal'] - $itemDiscount;
            $itemGst = round($taxableValue * $itemData['gst_percentage'] / 100, 2);
            $itemTotal = $taxableValue + $itemGst;

            $itemData['discount_amount'] = $itemDiscount;
            $itemData['gst_amount'] = $itemGst;
            $itemData['total_price'] = $itemTotal;

            $gstTotal += $itemGst;
        }
        unset($itemData);

        $grandTotal = $discountedSubtotal + $gstTotal;

        return [
            'items' => $items,
            'subtotal' => round($subtotal, 2),
            'discount' => round($discount, 2),
            'discounted_subtotal' => round($discountedSubtotal, 2),
            'gst_total' => round($gstTotal, 2),
            'max_gst_percentage' => $maxGstPercentage,
            'shipping' => 0,
            'shipping_gst' => 0,
            'grand_total' => round($grandTotal),
        ];
    }
}
