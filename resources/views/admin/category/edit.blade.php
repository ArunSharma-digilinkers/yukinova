@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')

    <div class="main-wrapper py-4">
        <div class="container-fluid">

            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-0">Edit Category</h2>
                    <small class="text-muted">Update category details</small>
                </div>

                <a href="{{ route('category.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Back
                </a>
            </div>

            <!-- Form Card -->
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-body">

                            <form method="POST" action="{{ route('category.update', $category->id) }}">
                                @csrf
                                @method('PUT')

                                <!-- Category Name -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        Category Name
                                    </label>
                                    <input type="text" name="name" value="{{ old('name', $category->name) }}"
                                        class="form-control" placeholder="Enter category name" required>
                                </div>

                                <!-- Status -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">
                                        Status
                                    </label>
                                    <select name="status" class="form-select">
                                        <option value="1" {{ $category->status ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="0" {{ !$category->status ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                    </select>
                                </div>

                                <!-- Buttons -->
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('category.index') }}" class="btn btn-light">
                                        Cancel
                                    </a>

                                    <button type="submit" class="btn btn-warning px-4">
                                        <i class="fas fa-save me-2"></i> Update
                                    </button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
