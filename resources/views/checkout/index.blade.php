@extends('layouts.main')

@section('content')
<div class="main-wrapper">
    <div class="container py-4">

        <h1 class="text-center fw-bold mb-3">Checkout</h1>
        <div class="mx-auto mb-5" style="max-width: 600px; height: 4px; background: #0f9b0f; border-radius: 2px;"></div>

        {{-- Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger mb-4">{{ session('error') }}</div>
        @endif

        <div class="row g-5">

            {{-- LEFT: Billing Details --}}
            <div class="col-lg-7">

                <h5 class="fw-bold mb-4">Billing Details</h5>

                {{-- Saved Address Selector (logged-in users) --}}
                @auth
                    @if($addresses->count())
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-muted mb-2">Use a saved address:</label>
                            <div class="row g-2">
                                @foreach($addresses as $addr)
                                <div class="col-md-6">
                                    <div class="border rounded p-3 address-card {{ $defaultAddress && $defaultAddress->id === $addr->id ? 'border-success' : '' }}"
                                         style="cursor: pointer; transition: all 0.2s;"
                                         onclick="fillAddress({{ $addr->id }}, this)">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <span class="badge bg-secondary mb-1">{{ $addr->label }}</span>
                                            @if($addr->is_default)
                                                <span class="badge bg-success" style="font-size: 10px;">Default</span>
                                            @endif
                                        </div>
                                        <p class="fw-semibold mb-0 small">{{ $addr->name }}</p>
                                        <p class="mb-0 small text-muted">{{ Str::limit($addr->address, 50) }}</p>
                                        <p class="mb-0 small text-muted">{{ $addr->city }}, {{ $addr->state }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <a href="{{ route('user.addresses.create') }}" class="small text-decoration-none mt-2 d-inline-block">
                                <i class="fas fa-plus me-1"></i> Add new address
                            </a>
                        </div>
                    @endif
                @endauth

                <form id="checkout-form" action="{{ route('checkout.place') }}" method="POST">
                    @csrf

                    <div class="row g-4">

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Full Name *</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name ?? '') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Mobile Number *</label>
                            <input type="text" name="phone" class="form-control" maxlength="10" value="{{ old('phone', auth()->user()->phone ?? '') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email *</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email ?? '') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Pincode *</label>
                            <input type="text" name="pincode" class="form-control" maxlength="6" value="{{ old('pincode') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">State *</label>
                            <select name="state" id="state-select" class="form-select" required onchange="updateShipping()">
                                <option value="">Select State</option>
                                @foreach(\App\Http\Controllers\Admin\ShippingZoneController::indianStates() as $state)
                                    <option value="{{ $state }}" {{ old('state') === $state ? 'selected' : '' }}>{{ $state }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">City *</label>
                            <input type="text" name="city" class="form-control" value="{{ old('city') }}" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Full Address *</label>
                            <textarea name="address" rows="3" class="form-control" required>{{ old('address') }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">GSTIN <small class="text-muted">(Optional)</small></label>
                            <input type="text" name="gstin" class="form-control" maxlength="15"
                                   value="{{ old('gstin', $userGstin) }}"
                                   placeholder="e.g. 22AAAAA0000A1Z5" style="text-transform: uppercase;">
                            @error('gstin')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    {{-- Ship to Different Address --}}
                    <div class="mt-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="ship-to-different" name="ship_to_different" value="1"
                                   {{ old('ship_to_different') ? 'checked' : '' }}
                                   onchange="toggleShippingForm()">
                            <label class="form-check-label fw-semibold" for="ship-to-different">
                                Ship to a different address
                            </label>
                        </div>

                        <div id="shipping-form" class="mt-4" style="{{ old('ship_to_different') ? '' : 'display: none;' }}">

                            <h6 class="fw-bold mb-3">Shipping Address</h6>

                            {{-- Saved Address Selector for Shipping --}}
                            @auth
                                @if($addresses->count())
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold text-muted mb-2 small">Use a saved address for shipping:</label>
                                        <div class="row g-2">
                                            @foreach($addresses as $addr)
                                            <div class="col-md-6">
                                                <div class="border rounded p-2 shipping-address-card small"
                                                     style="cursor: pointer; transition: all 0.2s;"
                                                     onclick="fillShippingAddress({{ $addr->id }}, this)">
                                                    <span class="badge bg-secondary mb-1" style="font-size: 9px;">{{ $addr->label }}</span>
                                                    <p class="fw-semibold mb-0" style="font-size: 12px;">{{ $addr->name }}</p>
                                                    <p class="mb-0 text-muted" style="font-size: 11px;">{{ Str::limit($addr->address, 40) }}</p>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endauth

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Full Name *</label>
                                    <input type="text" name="shipping_name" class="form-control" value="{{ old('shipping_name') }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Mobile Number *</label>
                                    <input type="text" name="shipping_phone" class="form-control" maxlength="10" value="{{ old('shipping_phone') }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Pincode *</label>
                                    <input type="text" name="shipping_pincode" class="form-control" maxlength="6" value="{{ old('shipping_pincode') }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">State *</label>
                                    <select name="shipping_state" id="shipping-state-select" class="form-select" onchange="updateShipping()">
                                        <option value="">Select State</option>
                                        @foreach(\App\Http\Controllers\Admin\ShippingZoneController::indianStates() as $state)
                                            <option value="{{ $state }}" {{ old('shipping_state') === $state ? 'selected' : '' }}>{{ $state }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">City *</label>
                                    <input type="text" name="shipping_city" class="form-control" value="{{ old('shipping_city') }}">
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold">Full Address *</label>
                                    <textarea name="shipping_address" rows="3" class="form-control">{{ old('shipping_address') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Razorpay Hidden Fields --}}
                    <input type="hidden" name="payment_method" value="razorpay">
                    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">

                </form>

            </div>

            {{-- RIGHT: Order Summary --}}
            <div class="col-lg-5">

                {{-- Order Items --}}
                <div class="border rounded p-4 mb-4">

                    <h5 class="fw-bold mb-4">Order Summary</h5>

                    @foreach($summary['items'] as $slug => $item)
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <span class="fw-semibold">{{ $item['name'] }}</span>
                                <span class="text-muted small d-block">Qty: {{ $item['quantity'] }}</span>
                            </div>
                            <span>₹{{ number_format($item['item_subtotal'], 2) }}</span>
                        </div>
                    @endforeach

                    <hr>

                    <div class="d-flex justify-content-between mb-2" id="subtotal-row">
                        <span class="text-muted">Subtotal</span>
                        <span id="subtotal-display">₹{{ number_format($summary['subtotal'], 2) }}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2 text-success" id="discount-row" style="{{ $summary['discount'] > 0 ? '' : 'display:none !important;' }}">
                        <span id="discount-label">{{ $coupon ? 'Discount (' . $coupon->code . ')' : 'Discount' }}</span>
                        <span id="discount-display">- ₹{{ number_format($summary['discount'], 2) }}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Shipping</span>
                        <span id="shipping-display" class="text-muted">Select state</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2" id="gst-row" style="{{ $summary['gst_total'] > 0 ? '' : 'display:none;' }}">
                        <span class="text-muted">GST</span>
                        <span id="gst-display">+ ₹{{ number_format($summary['gst_total'], 2) }}</span>
                    </div>

                    <div id="roundoff-row" class="d-flex justify-content-between mb-2" style="display: none !important;">
                        <span class="text-muted">Round Off</span>
                        <span id="roundoff-display"></span>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <span class="fw-bold fs-5">Total</span>
                        <span class="fw-bold fs-5" id="total-display">₹{{ number_format($summary['grand_total']) }}</span>
                    </div>

                </div>

                {{-- Coupon Section --}}
                <div class="mb-4" id="coupon-section">
                    {{-- Applied coupon display --}}
                    <div id="coupon-applied" class="border rounded p-4" style="display: {{ $coupon ? 'block' : 'none' }};">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-success px-3 py-2" id="coupon-badge">
                                @if($coupon)
                                    <i class="fas fa-tag me-1"></i> {{ $coupon->code }}
                                    @if($coupon->type === 'percentage')
                                        ({{ $coupon->value }}% off)
                                    @else
                                        (₹{{ number_format($coupon->value, 2) }} off)
                                    @endif
                                @endif
                            </span>
                            <a href="#" onclick="removeCoupon(); return false;" class="text-danger small text-decoration-underline">Remove</a>
                        </div>
                    </div>

                    {{-- Coupon input form --}}
                    <div id="coupon-form-wrap" style="display: {{ $coupon ? 'none' : 'block' }};">
                        <div class="form-check mb-0">
                            <input class="form-check-input" type="checkbox" id="coupon-toggle"
                                   onchange="document.getElementById('coupon-box').style.display = this.checked ? 'block' : 'none'">
                            <label class="form-check-label" for="coupon-toggle">Have a coupon code?</label>
                        </div>

                        <div id="coupon-box" class="border rounded p-4 mt-3" style="display: none;">
                            <div id="coupon-message"></div>
                            <div class="input-group">
                                <input type="text" id="coupon-input" class="form-control"
                                       placeholder="Enter coupon code" style="text-transform: uppercase;">
                                <button class="btn btn-outline-success" type="button" id="coupon-apply-btn" onclick="applyCoupon()">Apply</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Pay Button --}}
                <button type="button" class="btn-submit w-100 text-center" id="pay-btn" onclick="payWithRazorpay()">
                    Pay ₹<span id="pay-amount">{{ number_format($summary['grand_total']) }}</span>
                </button>

            </div>

        </div>

    </div>
</div>

{{-- Razorpay Script --}}
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
// Base totals from server (without shipping)
let baseSubtotal = {{ $summary['subtotal'] }};
let baseDiscount = {{ $summary['discount'] }};
let baseProductGst = {{ $summary['gst_total'] }};
let currentShipping = 0;
let currentShippingGst = 0;
let shippingResolved = false;

function toggleShippingForm() {
    let checked = document.getElementById('ship-to-different').checked;
    document.getElementById('shipping-form').style.display = checked ? '' : 'none';
    updateShipping();
}

function updateShipping() {
    let shipDifferent = document.getElementById('ship-to-different').checked;
    let state = shipDifferent
        ? document.getElementById('shipping-state-select').value
        : document.getElementById('state-select').value;
    let shippingEl = document.getElementById('shipping-display');

    if (!state) {
        shippingEl.innerHTML = '<span class="text-muted">Select state</span>';
        shippingResolved = false;
        currentShippingGst = 0;
        recalcTotal(0);
        return;
    }

    shippingEl.innerHTML = '<span class="text-muted">Calculating...</span>';

    fetch("{{ route('checkout.shippingCost') }}?state=" + encodeURIComponent(state), {
        headers: { 'Accept': 'application/json' }
    })
    .then(res => res.json())
    .then(data => {
        if (data.error) {
            shippingEl.innerHTML = '<span class="text-danger">' + data.error + '</span>';
            shippingResolved = false;
            currentShippingGst = 0;
            recalcTotal(0);
            return;
        }

        shippingResolved = true;
        currentShippingGst = data.shipping_gst || 0;

        if (data.free || data.shipping == 0) {
            shippingEl.innerHTML = '<span class="text-success">Free</span>';
            currentShippingGst = 0;
            recalcTotal(0);
        } else {
            shippingEl.innerHTML = '₹' + Number(data.shipping).toLocaleString('en-IN');
            recalcTotal(data.shipping);
        }
    })
    .catch(() => {
        shippingEl.innerHTML = '<span class="text-danger">Error</span>';
        shippingResolved = false;
        currentShippingGst = 0;
    });
}

function recalcTotal(shipping) {
    currentShipping = shipping;

    // Consolidated GST = product GST + shipping GST
    let consolidatedGst = baseProductGst + currentShippingGst;

    // Update GST display (consolidated)
    let gstRow = document.getElementById('gst-row');
    if (consolidatedGst > 0) {
        gstRow.style.display = '';
        document.getElementById('gst-display').textContent = '+ ₹' + consolidatedGst.toFixed(2);
    } else {
        gstRow.style.display = 'none';
    }

    let exactTotal = (baseSubtotal - baseDiscount) + consolidatedGst + shipping;
    let roundedTotal = Math.round(exactTotal);
    let roundOff = roundedTotal - exactTotal;

    // Update round off row
    let roundRow = document.getElementById('roundoff-row');
    let roundDisplay = document.getElementById('roundoff-display');
    if (Math.abs(roundOff) >= 0.01) {
        roundRow.style.display = '';
        roundRow.style.removeProperty('display');
        let sign = roundOff >= 0 ? '+' : '-';
        roundDisplay.textContent = sign + ' ₹' + Math.abs(roundOff).toFixed(2);
    } else {
        roundRow.style.display = 'none';
    }

    // Update total
    document.getElementById('total-display').textContent = '₹' + roundedTotal.toLocaleString('en-IN');
    document.getElementById('pay-amount').textContent = roundedTotal.toLocaleString('en-IN');
}

function payWithRazorpay() {
    let form = document.getElementById('checkout-form');
    let name = form.querySelector('[name="name"]').value;
    let phone = form.querySelector('[name="phone"]').value;
    let email = form.querySelector('[name="email"]').value;
    let state = form.querySelector('[name="state"]').value;
    let address = form.querySelector('[name="address"]').value;

    if (!name || !phone || !email || !state || !address) {
        alert('Please fill all billing details first.');
        return;
    }

    let shipDifferent = document.getElementById('ship-to-different').checked;
    if (shipDifferent) {
        let sName = form.querySelector('[name="shipping_name"]').value;
        let sPhone = form.querySelector('[name="shipping_phone"]').value;
        let sState = form.querySelector('[name="shipping_state"]').value;
        let sCity = form.querySelector('[name="shipping_city"]').value;
        let sAddress = form.querySelector('[name="shipping_address"]').value;

        if (!sName || !sPhone || !sState || !sCity || !sAddress) {
            alert('Please fill all shipping address details.');
            return;
        }
    }

    if (!shippingResolved) {
        alert('Please select a state to calculate shipping.');
        return;
    }

    let consolidatedGst = baseProductGst + currentShippingGst;
    let exactTotal = (baseSubtotal - baseDiscount) + consolidatedGst + currentShipping;
    let finalAmount = Math.round(exactTotal);

    let options = {
        key: "{{ config('services.razorpay.key') }}",
        amount: finalAmount * 100,
        currency: "INR",
        name: "EVFAST",
        description: "Order Payment",
        handler: function (response) {
            document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
            form.submit();
        },
        prefill: {
            name: name,
            email: email,
            contact: phone
        },
        theme: {
            color: "#0f9b0f"
        }
    };

    let rzp = new Razorpay(options);

    // Save checkout attempt before opening payment (for abandoned checkout tracking)
    fetch("{{ route('checkout.saveAbandoned') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            name: name,
            email: email,
            phone: phone,
            address: form.querySelector('[name="address"]').value,
            pincode: form.querySelector('[name="pincode"]').value,
            state: state,
            city: form.querySelector('[name="city"]').value,
            total_amount: finalAmount
        })
    })
    .then(() => rzp.open())
    .catch(() => rzp.open());
}

// Auto-trigger if state was pre-selected (e.g. from old() after validation error)
document.addEventListener('DOMContentLoaded', function() {
    let shipDifferent = document.getElementById('ship-to-different').checked;
    if (shipDifferent) {
        let shippingState = document.getElementById('shipping-state-select');
        if (shippingState.value) {
            updateShipping();
        }
    } else {
        let stateSelect = document.getElementById('state-select');
        if (stateSelect.value) {
            updateShipping();
        }
    }
});

function fillAddress(addressId, el) {
    fetch('/checkout/address/' + addressId, {
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => {
        if (!res.ok) throw new Error('Failed');
        return res.json();
    })
    .then(data => {
        let form = document.getElementById('checkout-form');
        form.querySelector('[name="name"]').value = data.name;
        form.querySelector('[name="phone"]').value = data.phone;
        form.querySelector('[name="pincode"]').value = data.pincode;
        form.querySelector('[name="city"]').value = data.city;
        form.querySelector('[name="address"]').value = data.address;

        let stateSelect = form.querySelector('[name="state"]');
        stateSelect.value = data.state;
        updateShipping();

        // Highlight selected card
        document.querySelectorAll('.address-card').forEach(c => c.classList.remove('border-success'));
        el.classList.add('border-success');
    })
    .catch(() => {
        alert('Could not load address. Please try again.');
    });
}

function fillShippingAddress(addressId, el) {
    fetch('/checkout/address/' + addressId, {
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => {
        if (!res.ok) throw new Error('Failed');
        return res.json();
    })
    .then(data => {
        let form = document.getElementById('checkout-form');
        form.querySelector('[name="shipping_name"]').value = data.name;
        form.querySelector('[name="shipping_phone"]').value = data.phone;
        form.querySelector('[name="shipping_pincode"]').value = data.pincode;
        form.querySelector('[name="shipping_city"]').value = data.city;
        form.querySelector('[name="shipping_address"]').value = data.address;

        let shippingStateSelect = form.querySelector('[name="shipping_state"]');
        shippingStateSelect.value = data.state;
        updateShipping();

        // Highlight selected card
        document.querySelectorAll('.shipping-address-card').forEach(c => c.classList.remove('border-success'));
        el.classList.add('border-success');
    })
    .catch(() => {
        alert('Could not load address. Please try again.');
    });
}

function applyCoupon() {
    let input = document.getElementById('coupon-input');
    let code = input.value.trim();
    let msgEl = document.getElementById('coupon-message');
    let btn = document.getElementById('coupon-apply-btn');

    if (!code) {
        msgEl.innerHTML = '<div class="alert alert-danger py-2 mb-3">Please enter a coupon code.</div>';
        return;
    }

    btn.disabled = true;
    btn.textContent = 'Applying...';
    msgEl.innerHTML = '';

    fetch("{{ route('checkout.applyCoupon') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ coupon_code: code })
    })
    .then(res => res.json())
    .then(data => {
        btn.disabled = false;
        btn.textContent = 'Apply';

        if (!data.success) {
            msgEl.innerHTML = '<div class="alert alert-danger py-2 mb-3">' + data.message + '</div>';
            return;
        }

        // Update summary values with coupon code for label
        updateSummaryFromServer(data.summary, data.coupon.code);

        // Show applied coupon badge
        let label = data.coupon.type === 'percentage'
            ? data.coupon.code + ' (' + data.coupon.value + '% off)'
            : data.coupon.code + ' (₹' + Number(data.coupon.value).toLocaleString('en-IN') + ' off)';
        document.getElementById('coupon-badge').innerHTML = '<i class="fas fa-tag me-1"></i> ' + label;
        document.getElementById('coupon-applied').style.display = 'block';
        document.getElementById('coupon-form-wrap').style.display = 'none';
    })
    .catch(() => {
        btn.disabled = false;
        btn.textContent = 'Apply';
        msgEl.innerHTML = '<div class="alert alert-danger py-2 mb-3">Something went wrong. Please try again.</div>';
    });
}

function removeCoupon() {
    fetch("{{ route('checkout.removeCoupon') }}", {
        headers: { 'Accept': 'application/json' }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            updateSummaryFromServer(data.summary);

            // Hide applied, show form
            document.getElementById('coupon-applied').style.display = 'none';
            document.getElementById('coupon-form-wrap').style.display = 'block';
            document.getElementById('coupon-toggle').checked = false;
            document.getElementById('coupon-box').style.display = 'none';
            document.getElementById('coupon-input').value = '';
            document.getElementById('coupon-message').innerHTML = '';

            // Hide discount row
            document.getElementById('discount-row').style.setProperty('display', 'none', 'important');
        }
    })
    .catch(() => {
        alert('Could not remove coupon. Please try again.');
    });
}

function updateSummaryFromServer(summary, couponCode) {
    baseSubtotal = summary.subtotal;
    baseDiscount = summary.discount;
    baseProductGst = summary.gst_total;

    // Update discount row - only show when coupon is applied and discount > 0
    let discountRow = document.getElementById('discount-row');
    if (couponCode && summary.discount > 0) {
        discountRow.style.setProperty('display', 'flex', 'important');
        document.getElementById('discount-label').textContent = 'Discount (' + couponCode + ')';
        document.getElementById('discount-display').textContent = '- ₹' + Number(summary.discount).toFixed(2);
    } else {
        discountRow.style.setProperty('display', 'none', 'important');
    }

    // Update subtotal display
    document.getElementById('subtotal-display').textContent = '₹' + Number(summary.subtotal).toFixed(2);

    // Recalc total with current shipping (this also updates consolidated GST display)
    recalcTotal(currentShipping);
}
</script>

<style>
.address-card:hover,
.shipping-address-card:hover {
    border-color: #0f9b0f !important;
    box-shadow: 0 2px 8px rgba(15, 155, 15, 0.15);
}
</style>
@endsection
