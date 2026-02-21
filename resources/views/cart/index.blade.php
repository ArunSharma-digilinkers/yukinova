@extends('layouts.main')

@section('content')
    <div class="main-wrapper section-entry">
        <div class="container py-5">

            @if (session('cart') && count(session('cart')) > 0)
                @php $grandTotal = 0; @endphp

                <h1 class="text-center fw-bold mb-3">Cart</h1>

                @if (session('error'))
                    <div class="alert alert-danger text-center">{{ session('error') }}</div>
                @endif

                {{-- Free shipping banner --}}
                <div class="text-center mb-2">
                    <span class="text-muted">You are eligible for free shipping.</span>
                </div>
                <div class="mx-auto mb-5" style="max-width: 600px; height: 4px; background: #0f9b0f; border-radius: 2px;">
                </div>

                <div class="row g-5">

                    {{-- LEFT: Cart Items --}}
                    <div class="col-lg-8">

                        {{-- Table Header --}}
                        <div class="row text-muted fw-semibold border-bottom pb-3 mb-3 d-none d-md-flex">
                            <div class="col-md-6">Product</div>
                            <div class="col-md-3 text-center">Quantity</div>
                            <div class="col-md-3 text-end">Total</div>
                        </div>

                        @foreach ($cart as $slug => $item)
                            @php
                                $itemTotal = $item['price'] * $item['quantity'];
                                $grandTotal += $itemTotal;
                            @endphp

                            <div class="row align-items-center py-4 border-bottom">

                                {{-- Product Info --}}
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ asset('storage/products/' . $item['image']) }}"
                                            alt="{{ $item['name'] }}" class="rounded"
                                            style="width: 90px; height: 90px; object-fit: contain; border: 1px solid #eee;">
                                        <div>
                                            <h6 class="fw-semibold mb-1">{{ $item['name'] }}</h6>
                                            <span class="text-muted">₹{{ number_format($item['price']) }}</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Quantity --}}
                                <div class="col-md-3 text-center mt-3 mt-md-0">
                                    <form action="{{ route('cart.update', $slug) }}" method="POST">
                                        @csrf
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                            class="form-control text-center mx-auto" style="max-width: 70px;"
                                            onchange="this.form.submit()">
                                    </form>
                                    <a href="{{ route('cart.remove', $slug) }}"
                                        class="text-muted small text-decoration-underline mt-1 d-inline-block">Remove</a>
                                </div>

                                {{-- Total --}}
                                <div class="col-md-3 text-end mt-3 mt-md-0">
                                    <span class="fw-semibold">₹{{ number_format($itemTotal) }}</span>
                                </div>

                            </div>
                        @endforeach

                    </div>

                    {{-- RIGHT: Order Summary --}}
                    <div class="col-lg-4">
                        <div class="border rounded p-4">

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Subtotal</span>
                                <span>₹{{ number_format($grandTotal) }}</span>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <span class="fw-bold fs-5">Total</span>
                                <span class="fw-bold fs-5">₹{{ number_format($grandTotal) }}</span>
                            </div>

                            <p class="text-muted small mb-4">
                                Tax included. Shipping calculated at checkout.
                            </p>

                            {{-- Checkout Button --}}
                            <a href="{{ route('checkout') }}" class="btn-submit w-100 text-center">
                                Proceed to Checkout
                            </a>
                            @guest
                                <p class="text-muted small mt-4">
                                    Existing user? <a href="{{ route('login', ['redirect' => url('/cart')]) }}">Login</a> for
                                    your saved info.
                                </p>
                            @endguest

                        </div>
                    </div>

                </div>
            @else
                {{-- Empty Cart --}}
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-4x text-muted mb-3 d-block text-center" style="display: inline-block; width: auto;"></i>
                    <h3 class="fw-bold mb-2">Your cart is empty</h3>
                    <p class="text-muted mb-4">Looks like you haven't added anything yet.</p>
                    <a href="{{ url('/') }}" class="btn-submit" style="display: inline-block; width: auto;">
                        Continue Shopping
                    </a>
                </div>
            @endif

        </div>
    </div>
@endsection
