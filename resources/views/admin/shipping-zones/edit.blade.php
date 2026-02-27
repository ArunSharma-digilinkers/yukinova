@extends('layouts.admin')

@section('title', 'Edit Shipping Zone')

@section('content')

    <div class="main-wrapper py-4">
        <div class="container-fluid">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-0">Edit Shipping Zone</h2>
                    <small class="text-muted">Update shipping zone details</small>
                </div>
                <a href="{{ route('shipping-zones.index') }}" class="btn btn-secondary shadow-sm">
                    <i class="fas fa-arrow-left me-2"></i> Back
                </a>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-body">
                    <form method="POST" action="{{ route('shipping-zones.update', $shipping_zone->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Zone Name *</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', $shipping_zone->name) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Rate Multiplier *</label>
                                <input type="number" name="rate" class="form-control" step="0.01" min="0"
                                    value="{{ old('rate', $shipping_zone->rate) }}" required placeholder="e.g. 1.2">
                                <small class="text-muted">1 = base rate, 1.2 = 20% extra, 1.5 = 50% extra</small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Free Shipping Above (₹)</label>
                                <input type="number" name="free_above" class="form-control" step="0.01" min="0"
                                    value="{{ old('free_above', $shipping_zone->free_above) }}">
                                <small class="text-muted">Leave empty if no free shipping threshold</small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Status *</label>
                                <select name="status" class="form-select" required>
                                    <option value="1" {{ old('status', $shipping_zone->status) ? 'selected' : '' }}>
                                        Active</option>
                                    <option value="0" {{ !old('status', $shipping_zone->status) ? 'selected' : '' }}>
                                        Inactive</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label">States *</label>
                                <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                                    <div class="row">
                                        @foreach ($states as $state)
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="states[]"
                                                        value="{{ $state }}" id="state-{{ $loop->index }}"
                                                        {{ in_array($state, old('states', $shipping_zone->states)) ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="state-{{ $loop->index }}">{{ $state }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <small class="text-muted">Select states/UTs for this zone</small>
                            </div>
                        </div>

                        <button class="btn btn-warning mt-4">
                            <i class="fas fa-save me-2"></i> Update Zone
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

@endsection
