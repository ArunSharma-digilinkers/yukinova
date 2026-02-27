@extends('layouts.admin')

@section('title', 'Shipping Zones')

@section('content')
    <div class="main-wrapper py-4">

        <div class="container-fluid">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-0">Shipping Zones</h2>
                    <small class="text-muted">Manage zone-based shipping rates</small>
                </div>

                <a href="{{ route('shipping-zones.create') }}" class="btn btn-submit">
                    <i class="fas fa-plus me-2"></i> Add Zone
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
                                <th width="50">#</th>
                                <th>Zone Name</th>
                                <th>States</th>
                                <th>Rate Multiplier</th>
                                <th>Free Above</th>
                                <th>Status</th>
                                <th width="120">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($zones as $zone)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td class="fw-semibold">{{ $zone->name }}</td>

                                    <td>
                                        @foreach ($zone->states as $state)
                                            <span class="badge bg-light text-dark border mb-1">{{ $state }}</span>
                                        @endforeach
                                    </td>

                                    <td class="fw-semibold">{{ $zone->rate }}x</td>

                                    <td>
                                        @if ($zone->free_above)
                                            {{ number_format($zone->free_above) }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($zone->status)
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
                                        <a href="{{ route('shipping-zones.edit', $zone->id) }}"
                                            class="btn btn-sm btn-warning me-1" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('shipping-zones.destroy', $zone->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Are you sure you want to delete this zone?')"
                                                class="btn btn-sm btn-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        No shipping zones found
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
