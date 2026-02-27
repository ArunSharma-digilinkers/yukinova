@extends('layouts.main')

@section('content')
<div class="main-wrapper section-entry">
    <div class="container">

        <div class="row g-5">

            {{-- LEFT : IMAGE GALLERY --}}
            <div class="col-md-6">

                @php
                $gallery = $product->images ?? [];
                @endphp

                {{-- Main Image --}}
                <div class="border rounded flex-fill text-center product-main-image">
                    <img id="mainImage" src="{{ asset('storage/products/' . $product->image) }}"
                        class="img-fluid main-img" alt="{{ $product->name }}">
                </div>
                {{-- Thumbnails --}}
                <div class="owl-carousel owl-theme gallery-carousel mt-3">

                    <div class="item">
                        <img src="{{ asset('storage/products/' . $product->image) }}"
                            class="img-thumbnail thumb active-thumb" onclick="changeImage(this)">
                    </div>

                    @foreach ($gallery as $img)
                    <div class="item">
                        <img src="{{ asset('storage/products/gallery/' . $img) }}" class="img-thumbnail thumb"
                            onclick="changeImage(this)">
                    </div>
                    @endforeach

                </div>

            </div>

            {{-- RIGHT : PRODUCT INFO --}}
            <div class="col-md-6">

                {{-- TITLE --}}
                <h2 class="fw-bold mb-1">{{ $product->name }}</h2>

                <p class="text-muted mb-2">
                    Category: <strong>{{ $product->category->name }}</strong>
                </p>

                {{-- PRICE --}}
                <div class="mb-1">
                    <h3 class="fw-bold pro-name d-inline mb-0">
                        ₹{{ number_format($product->price) }}
                    </h3>

                    @if ($product->sale_price && $product->sale_price > $product->price)

                    <span class="text-muted fs-6 text-decoration-line-through ms-2">
                        ₹{{ number_format($product->sale_price) }}
                    </span>

                    @php
                    $discountPct = floor(
                    (($product->sale_price - $product->price) / $product->sale_price) * 100
                    );
                    @endphp

                    <span class="badge bg-danger ms-2">{{ $discountPct }}% off</span>

                    @endif

                </div>

                <p class="text-muted small mb-3">
                    @if ($product->gst_percentage > 0)
                    @if ($product->gst_type === 'inclusive')
                    Inclusive of GST ({{ rtrim(rtrim(number_format($product->gst_percentage, 2), '0'), '.') }}%)
                    @else
                    + {{ rtrim(rtrim(number_format($product->gst_percentage, 2), '0'), '.') }}% GST extra
                    @endif
                    @else
                    Price inclusive of all taxes
                    @endif
                    <br>
                    @php
                    $shipping = strtolower($product->shipping_type ?? '');
                    @endphp

                    @if($shipping === 'free')
                    Free Shipping
                    @elseif($shipping === 'zone')
                    Shipping charges extra
                    @else
                    Shipping charges extra
                    @endif
                </p>

                {{-- FEATURES (CKEDITOR CONTENT) --}}
                <div class="product-detail-feature mb-3">
                    {!! $product->short_description ?? '<p>N/A</p>' !!}
                </div>

                @if ($product->quantity > 0)
                {{-- QUANTITY --}}
                <div id="cart-actions" class="mb-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <label class="fw-semibold mb-0">Qty:</label>
                        <div class="d-flex align-items-center border rounded">
                            <button type="button" class="btn btn-sm px-3 py-1" onclick="changeQty(-1)">−</button>
                            <input type="number" id="product-qty" value="1" min="1" max="{{ $product->quantity }}"
                                class="form-control form-control-sm text-center border-0" style="width: 50px;" readonly>
                            <button type="button" class="btn btn-sm px-3 py-1" onclick="changeQty(1)">+</button>
                        </div>
                        <small class="text-muted">{{ $product->quantity }} in stock</small>
                    </div>

                    {{-- ACTION BUTTONS --}}
                    <div class="d-flex gap-2 flex-wrap align-items-center">

                        <button type="button" class="btn-submit" id="add-to-cart-btn" onclick="addToCart()">
                            Add to cart
                        </button>

                        <button type="button" class="btn-submit" onclick="buyNow()">
                            Buy Now
                        </button>
                    </div>
                </div>
                @else
                {{-- OUT OF STOCK --}}
                <div class="mb-4">
                    <span class="badge bg-danger fs-6 px-3 py-2 mb-3">Out of Stock</span>
                    <div class="d-flex gap-2 flex-wrap align-items-center">
                        <a href="https://wa.me/918595264742?text={{ urlencode('Enquiry about ' . $product->name . ' (Out of Stock)') }}"
                            target="_blank" class="btn-submit">
                            <i class="fab fa-whatsapp me-1"></i> Notify me when available
                        </a>
                    </div>
                </div>
                @endif

                {{-- CART SUCCESS MESSAGE (hidden by default) --}}
                <div id="cart-success-msg" class="mb-4" style="display: none;">
                    <div class="alert alert-success d-flex align-items-center gap-2 mb-3">
                        <i class="fas fa-check-circle"></i>
                        <span>Product added to cart!</span>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('cart.index') }}" class="btn-submit">
                            <i class="fas fa-shopping-cart me-1"></i> Go to Cart
                        </a>
                        <a href="{{ route('category.products', $product->category->slug)
                            }}" class="btn-submit">
                            Keep Shopping
                        </a>
                    </div>
                </div>
                {{-- SHARE BUTTON --}}
                <div class="mt-4">
                    <button type="button" class="share-btn" onclick="shareProduct()">
                        <i class="fas fa-share-alt me-1"></i> Share
                    </button>
                </div>
            </div>

            <div class="col-lg-12 mt-5">

                <div class="product-details-wrapper">

                    {{-- TAB HEADERS --}}
                    <ul class="nav product-tabs" id="productTab" role="tablist">

                        @if(!empty(strip_tags($product->description)))
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#description">
                                Description
                            </button>
                        </li>
                        @endif

                        @if(!empty($product->technical_features))
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#features">
                                Technical Features
                            </button>
                        </li>
                        @endif

                        @if(!empty($product->warranty))
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#warranty">
                                Warranty
                            </button>
                        </li>
                        @endif

                    </ul>

                    {{-- TAB CONTENT --}}
                    <div class="tab-content product-tab-content">

                        @if(!empty(strip_tags($product->description)))
                        <div class="tab-pane fade show active" id="description">

                            <div class="tab-card">
                                {!! $product->description !!}
                            </div>

                        </div>
                        @endif


                        @if(!empty($product->technical_features))
                        <div class="tab-pane fade" id="features">

                            <div class="tab-card">
                                {!! $product->technical_features !!}
                            </div>

                        </div>
                        @endif


                        @if(!empty($product->warranty))
                        <div class="tab-pane fade" id="warranty">

                            <div class="tab-card">
                                {!! $product->warranty !!}
                            </div>

                        </div>
                        @endif

                    </div>

                </div>

            </div>
        </div>


    </div>
</div>

{{-- JS --}}
<script>
function changeImage(el) {
    document.getElementById('mainImage').src = el.src;
    document.querySelectorAll('.thumb').forEach(i => i.classList.remove('active-thumb'));
    el.classList.add('active-thumb');
}

function shareProduct() {
    if (navigator.share) {
        navigator.share({
            title: "{{ $product->name }}",
            text: "Check out this product",
            url: "{{ url()->current() }}"
        });
    } else {
        navigator.clipboard.writeText("{{ url()->current() }}");
        alert('Product link copied!');
    }
}

function changeQty(delta) {
    let input = document.getElementById('product-qty');
    let max = parseInt(input.getAttribute('max')) || 999;
    let val = parseInt(input.value) + delta;
    if (val < 1) val = 1;
    if (val > max) val = max;
    input.value = val;
}

function buyNow() {
    let qty = document.getElementById('product-qty').value;

    fetch("{{ route('cart.add', $product->slug) }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                quantity: qty
            }),
        })
        .then(res => res.json().then(data => ({
            ok: res.ok,
            data
        })))
        .then(({
            ok,
            data
        }) => {
            if (ok && data.success) {
                window.location.href = "{{ route('checkout') }}";
            } else {
                alert(data.message || 'Something went wrong.');
            }
        })
        .catch(() => {
            alert('Something went wrong. Please try again.');
        });
}

function addToCart() {
    let btn = document.getElementById('add-to-cart-btn');
    let qty = document.getElementById('product-qty').value;
    btn.disabled = true;
    btn.textContent = 'Adding...';

    fetch("{{ route('cart.add', $product->slug) }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                quantity: qty
            }),
        })
        .then(res => res.json().then(data => ({
            ok: res.ok,
            data
        })))
        .then(({
            ok,
            data
        }) => {
            if (ok && data.success) {
                document.getElementById('cart-actions').style.display = 'none';
                document.getElementById('cart-success-msg').style.display = 'block';
            } else {
                btn.disabled = false;
                btn.textContent = 'Add to cart';
                alert(data.message || 'Something went wrong.');
            }
        })
        .catch(() => {
            btn.disabled = false;
            btn.textContent = 'Add to cart';
            alert('Something went wrong. Please try again.');
        });
}
</script>

{{-- CSS --}}
<style>
.thumb {
    width: 70px;
    cursor: pointer;
    border: 2px solid transparent;
}

.active-thumb {
    border-color: #198754;
}

.main-img {
    max-height: 420px;
    object-fit: contain;
}

.addon-card {
    transition: box-shadow 0.2s, transform 0.2s;
}

.addon-card:hover {
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transform: translateY(-3px);
}
</style>
@endsection