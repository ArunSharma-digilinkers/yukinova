@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
    <div class="main-wrapper py-4">

        <div class="container-fluid">

            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-0">Product Categories</h2>
                    <small class="text-muted">Manage your product categories</small>
                </div>

                <a href="{{ route('category.create') }}" class="btn-submit">
                    <i class="fas fa-plus me-2"></i> Add Category
                </a>
            </div>

            <!-- Table Card -->
            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <table class="table align-middle table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="60">#</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th width="160">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($categories as $category)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td class="fw-semibold">
                                        {{ $category->name }}
                                    </td>

                                    <td>
                                        @if ($category->status)
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
                                     

                                        <a href="{{ route('category.edit', $category->id) }}"
                                            class="btn btn-sm btn-warning me-1" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('category.destroy', $category->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                onclick="return confirm('Are you sure you want to delete this category?')"
                                                class="btn btn-sm btn-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        No categories found
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
