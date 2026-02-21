@extends('layouts.admin')

@section('title', 'Add Coupon')

@section('content')

<div class="main-wrapper py-4">
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-0">Add Coupon</h2>
                <small class="text-muted">Create a new discount coupon</small>
            </div>
            <a href="{{ route('coupons.index') }}" class="btn btn-secondary shadow-sm">
                <i class="fas fa-arrow-left me-2"></i> Back
            </a>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <form method="POST" action="{{ route('coupons.store') }}">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Coupon Code *</label>
                            <input type="text" name="code" class="form-control" value="{{ old('code') }}" required
                                   placeholder="e.g. SAVE20" style="text-transform: uppercase;">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Discount Type *</label>
                            <select name="type" class="form-select" required>
                                <option value="flat" {{ old('type') === 'flat' ? 'selected' : '' }}>Flat (Fixed Amount)</option>
                                <option value="percentage" {{ old('type') === 'percentage' ? 'selected' : '' }}>Percentage</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Discount Value *</label>
                            <input type="number" name="value" class="form-control" step="0.01" min="0"
                                   value="{{ old('value') }}" required placeholder="e.g. 500 or 10">
                            <small class="text-muted">Amount in ₹ for flat, or % for percentage</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Max Discount (for percentage)</label>
                            <input type="number" name="max_discount" class="form-control" step="0.01" min="0"
                                   value="{{ old('max_discount') }}" placeholder="e.g. 1000">
                            <small class="text-muted">Leave empty for no cap</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Minimum Order Amount</label>
                            <input type="number" name="min_order_amount" class="form-control" step="0.01" min="0"
                                   value="{{ old('min_order_amount') }}" placeholder="e.g. 2000">
                            <small class="text-muted">Leave empty for no minimum</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Max Uses *</label>
                            <input type="number" name="max_uses" class="form-control" min="1"
                                   value="{{ old('max_uses', 1) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Expiry Date *</label>
                            <input type="date" name="expires_at" class="form-control"
                                   value="{{ old('expires_at') }}" required min="{{ date('Y-m-d') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Status *</label>
                            <select name="status" class="form-select" required>
                                <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <button class="btn btn-success mt-4">
                        <i class="fas fa-save me-2"></i> Save Coupon
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection
