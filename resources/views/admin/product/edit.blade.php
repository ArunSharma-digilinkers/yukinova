@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')

<div class="main-wrapper py-4">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-0">Edit Product</h2>
                <small class="text-muted">Update product information</small>
            </div>

            <a href="{{ route('product.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i> Back
            </a>
        </div>

        <!-- Form Card -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-body">

                        @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form method="POST" action="{{ route('product.update', $product->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-4">
                                    <!-- Category -->
                                    <div class="mb-3">
                                        <label class="form-label">Category <span class="text-danger">*</span></label>
                                        <select name="category_id" class="form-select" required>
                                            @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}"
                                                {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <!-- Product Name -->
                                    <div class="mb-3">
                                        <label class="form-label">Product Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="name" value="{{ old('name', $product->name) }}"
                                            class="form-control" required>
                                    </div>

                                </div>

                                 <div class="col-md-4">
                                    <!-- Product Name -->
                                    <div class="mb-3">
                                        <label class="form-label">HSN Code <span
                                                class="text-danger"></span></label>
                                        <input type="number" name="hsn_code" value="{{ old('hsn_code', $product->hsn_code) }}"
                                            class="form-control" required>
                                    </div>

                                </div>
                            </div>

                            <!-- Price & Quantity -->
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Price (₹) <span class="text-danger">*</span></label>
                                    <input type="number" name="price" value="{{ old('price', $product->price) }}"
                                        class="form-control" required>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">MRP (₹) <span class="text-danger">*</span></label>
                                    <input type="number" name="sale_price"
                                        value="{{ old('sale_price', $product->sale_price) }}" class="form-control"
                                        required>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Quantity <span class="text-danger">*</span></label>
                                    <input type="number" name="quantity"
                                        value="{{ old('quantity', $product->quantity) }}" class="form-control" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">GST Percentage (%)</label>
                                    <input type="number" name="gst_percentage" class="form-control" step="0.01" min="0"
                                        value="{{ old('gst_percentage', $product->gst_percentage) }}"
                                        placeholder="e.g. 18">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">GST Type</label>
                                    <select name="gst_type" class="form-select">
                                        <option value="inclusive"
                                            {{ old('gst_type', $product->gst_type) === 'inclusive' ? 'selected' : '' }}>
                                            Inclusive (Price includes GST)</option>
                                        <option value="extra"
                                            {{ old('gst_type', $product->gst_type) === 'extra' ? 'selected' : '' }}>
                                            Extra (GST added on top)</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Shipping Type</label>
                                    <select name="shipping_type" class="form-select" id="shipping-type"
                                        onchange="toggleShippingRate()">
                                        <option value="free"
                                            {{ old('shipping_type', $product->shipping_type) === 'free' ? 'selected' : '' }}>
                                            Free Shipping</option>
                                        <option value="zone"
                                            {{ old('shipping_type', $product->shipping_type) === 'zone' ? 'selected' : '' }}>
                                            Zone + Product Based Shipping</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3" id="shipping-rate-wrap"
                                    style="{{ old('shipping_type', $product->shipping_type) === 'zone' ? '' : 'display:none;' }}">
                                    <label class="form-label">Product Shipping Rate (&#8377;)</label>
                                    <input type="number" name="shipping_rate" class="form-control" step="0.01" min="0"
                                        value="{{ old('shipping_rate', $product->shipping_rate) }}"
                                        placeholder="e.g. 150">
                                    <small class="text-muted">Per-unit shipping charge for this product</small>
                                </div>
                            </div>
                            <!-- Description -->
                            <div class="mb-3">
                                <label class="form-label">Short Description</label>
                                <textarea name="short_description" class="form-control ckeditor"
                                    rows="3">{{ old('short_description', $product->short_description) }}</textarea>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label class="form-label">Long Description</label>
                                <textarea name="description" class="form-control ckeditor"
                                    rows="3">{{ old('description', $product->description) }}</textarea>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label class="form-label">Technical Features</label>
                                <textarea name="technical_features" class="form-control ckeditor"
                                    rows="3">{{ old('technical_features', $product->technical_features) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Product Warranty</label>
                                <textarea name="warranty" class="form-control ckeditor"
                                    rows="3">{{ old('warranty', $product->warranty) }}</textarea>
                            </div>

                            <!-- Main Image -->
                            <div class="mb-4">
                                <label class="form-label">Main Image</label>
                                <input type="file" name="image" class="form-control mb-2">

                                @if ($product->image)
                                <img src="{{ asset('storage/products/' . $product->image) }}" class="img-thumbnail"
                                    width="150">
                                @endif
                            </div>

                            <!-- Gallery Images -->
                            <div class="mb-4">
                                <label class="form-label">Gallery Images</label>
                                <input type="file" name="images[]" class="form-control mb-3" multiple>


                                @if ($product->images)
                                <div class="row">
                                    @foreach ($product->images as $img)
                                    <div class="col-3 mb-3 text-center" id="image-box-{{ $loop->index }}">

                                        <div class="position-relative">
                                            <img src="{{ asset('storage/products/gallery/' . $img) }}"
                                                class="img-thumbnail w-100">

                                            <!-- Remove Button -->
                                            <button type="button"
                                                class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                                                onclick="removeImage('{{ $img }}', {{ $loop->index }})">
                                                &times;
                                            </button>
                                        </div>

                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>

                            <!-- Hidden field to store removed images -->
                            <input type="hidden" name="removed_images" id="removed_images">

                            <!-- Status -->
                            <div class="mb-4">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="1" {{ $product->status ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ !$product->status ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                                    <!-- Product Labels -->
                            <div class="mb-4">
                                <label class="form-label">Product Labels</label>

                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_new_arrival" value="1"
                                        id="newArrivalSwitch"
                                        {{ old('is_new_arrival', $product->is_new_arrival) ? 'checked' : '' }}>

                                    <label class="form-check-label" for="newArrivalSwitch">
                                        Mark as New Arrival
                                    </label>
                                </div>
                            </div>


                            <!-- Buttons -->
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('product.index') }}" class="btn btn-light">
                                    Cancel
                                </a>

                                <button type="submit" class="btn btn-warning px-4">
                                    <i class="fas fa-save me-2"></i> Update Product
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
function toggleShippingRate() {
    let wrap = document.getElementById('shipping-rate-wrap');
    wrap.style.display = document.getElementById('shipping-type').value === 'zone' ? '' : 'none';
}
</script>
@endsection