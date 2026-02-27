@extends('layouts.main')
@section('content')

<div class="main-wrapper">

    <div class="new-product-wrapper section-entry">
        <div class="container">

            <div class="section-title text-center mb-5">
                <h3>Hybrid Inverter</h3>
                <p>Explore our latest products</p>
            </div>

           <div class="new-product-grid">
                @forelse($products as $product)

                <div class="new-product-card">
                    <a href="{{ route('product.show', $product->slug) }}">
                        <div class="product-image">
                            <img src="{{ $product->image
                        ? asset('storage/products/'.$product->image)
                        : asset('img/no-image.png') }}" alt="{{ $product->name }}" alt="">
                        </div>

                        <div class="product-content">
                            <h4>{{ $product->name }}</h4>
                                <p>
                                {{ Str::limit(strip_tags($product->description), 20) }}
                            </p>
                            <p class="price">₹ {{ $product->base_price }}</p>

                            <a href="{{ route('product.show', $product->slug) }}" class="btn-view">
                                View Details
                            </a>
                        </div>
                    </a>
                </div>

                @empty
                <p class="text-center w-100">No products found in this category.</p>
                @endforelse
            </div>

        </div>
    </div>

</div>

@endsection