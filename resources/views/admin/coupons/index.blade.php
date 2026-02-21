@extends('layouts.admin')

@section('title', 'Coupons')

@section('content')
    <div class="main-wrapper py-4">

        <div class="container-fluid">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-0">Discount Coupons</h2>
                    <small class="text-muted">Manage your discount coupons</small>
                </div>

                <a href="{{ route('coupons.create') }}" class="btn btn-submit">
                    <i class="fas fa-plus me-2"></i> Add Coupon
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <table class="table align-middle table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Code</th>
                                <th>Type</th>
                                <th>Value</th>
                                <th>Max Discount</th>
                                <th>Min Order</th>
                                <th>Usage</th>
                                <th>Expires</th>
                                <th>Status</th>
                                <th width="160">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($coupons as $coupon)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="fw-semibold">{{ $coupon->code }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ ucfirst($coupon->type) }}</span>
                                    </td>
                                    <td>
                                        @if ($coupon->type === 'percentage')
                                            {{ $coupon->value }}%
                                        @else
                                            ₹{{ number_format($coupon->value, 2) }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ $coupon->max_discount ? '₹' . number_format($coupon->max_discount, 2) : '-' }}
                                    </td>
                                    <td>
                                        {{ $coupon->min_order_amount ? '₹' . number_format($coupon->min_order_amount, 2) : '-' }}
                                    </td>
                                    <td>{{ $coupon->used_count }} / {{ $coupon->max_uses }}</td>
                                    <td>
                                        @if ($coupon->expires_at->lt(now()->startOfDay()))
                                            <span class="text-danger">{{ $coupon->expires_at->format('d M Y') }}</span>
                                        @else
                                            {{ $coupon->expires_at->format('d M Y') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($coupon->status === 'active')
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i> Active
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-times-circle me-1"></i> Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('coupons.edit', $coupon->id) }}"
                                            class="btn btn-sm btn-warning me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('coupons.destroy', $coupon->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Are you sure you want to delete this coupon?')"
                                                class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted py-4">
                                        No coupons found
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
