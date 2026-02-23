@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
    <div class="main-wrapper py-4">
        <div class="container-fluid">
            <h2 class="mb-4">All Orders</h2>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form id="bulk-invoice-form" action="{{ route('admin.invoices.bulk') }}" method="POST">
                @csrf
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div></div>
                    <button type="submit" class="btn btn-outline-success btn-sm" id="bulk-download-btn" style="display: none; border-radius: 50px;">
                        <i class="fas fa-file-pdf me-1"></i> Download Selected Invoices
                    </button>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 40px;">
                                        <input type="checkbox" id="select-all" class="form-check-input">
                                    </th>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Total Amount</th>
                                    <th>Payment</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td>
                                            @if($order->invoice_number)
                                                <input type="checkbox" name="order_ids[]" value="{{ $order->id }}" class="form-check-input order-checkbox">
                                            @endif
                                        </td>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $order->name }}</td>
                                        <td>{{ $order->email }}</td>
                                        <td>{{ $order->phone }}</td>
                                        <td>₹{{ number_format($order->total_amount) }}</td>
                                        <td><span class="badge {{ $order->payment_status == 'paid' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($order->payment_status ?? 'N/A') }}</span></td>
                                        <td>
                                            @php
                                                $statusColors = ['pending' => 'warning', 'dispatched' => 'info', 'completed' => 'success', 'canceled' => 'danger'];
                                            @endphp
                                            <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }}">{{ ucfirst($order->status ?? 'pending') }}</span>
                                        </td>
                                        <td>{{ $order->created_at->format('d M Y') }}</td>
                                        <td>
                                            <a href="{{ route('admin.orders.show', $order->id) }}"
                                                class="btn btn-sm btn-submit">View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center text-muted">No orders found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const selectAll = document.getElementById('select-all');
                    const checkboxes = document.querySelectorAll('.order-checkbox');
                    const bulkBtn = document.getElementById('bulk-download-btn');

                    function updateBulkBtn() {
                        const checked = document.querySelectorAll('.order-checkbox:checked').length;
                        bulkBtn.style.display = checked > 0 ? 'inline-block' : 'none';
                    }

                    selectAll.addEventListener('change', function() {
                        checkboxes.forEach(cb => cb.checked = this.checked);
                        updateBulkBtn();
                    });

                    checkboxes.forEach(cb => {
                        cb.addEventListener('change', function() {
                            selectAll.checked = document.querySelectorAll('.order-checkbox:checked').length === checkboxes.length;
                            updateBulkBtn();
                        });
                    });
                });
            </script>

        </div>
    </div>
@endsection
