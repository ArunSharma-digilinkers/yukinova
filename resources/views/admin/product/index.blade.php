@extends('layouts.admin')

@section('title', 'Products')

@section('content')

    <div class="main-wrapper py-4">
        <div class="container-fluid">

            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-0">Products</h2>
                    <small class="text-muted">Manage your product inventory</small>
                </div>

                <a href="{{ route('product.create') }}" class="btn btn-submit">
                    <i class="fas fa-plus me-2"></i> Add Product
                </a>
            </div>

            <!-- Products Table -->
            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <table class="table align-middle table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="60">#</th>
                                <th>Product</th>
                                <th>Category</th>
                                <th>MRP</th>
                                <th>Sales Price</th>
                                <th>Qty</th>
                                <th>Status</th>
                                <th>Image</th>
                                <th width="150">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td class="fw-semibold">
                                        {{ $product->name }}
                                    </td>

                                    <td>
                                        <span class="badge bg-light text-dark">
                                            {{ $product->category->name }}
                                        </span>
                                    </td>

                                    <td class="fw-semibold">
                                        ₹{{ number_format($product->price) }}
                                    </td>
                                    <td class="fw-semibold">
                                        ₹{{ number_format($product->sale_price) }}
                                    </td>

                                    <td>
                                        {{ $product->quantity }}
                                    </td>

                                    {{-- ✅ STATUS --}}
                                    <td>
                                        @if ($product->status)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i> Active
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-times-circle me-1"></i> Inactive
                                            </span>
                                        @endif
                                    </td>

                                    {{-- ✅ IMAGE --}}
                                    <td>
                                        @if ($product->image)
                                            <img src="{{ asset('storage/products/' . $product->image) }}" width="60"
                                                class="img-thumbnail">
                                        @else
                                            <span class="text-muted">No Image</span>
                                        @endif
                                    </td>

                                    {{-- ✅ ACTION --}}
                                    <td>
                                        <a href="{{ route('product.edit', $product->id) }}"
                                            class="btn btn-sm btn-warning me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('product.destroy', $product->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        No products found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </div>

@endsection
