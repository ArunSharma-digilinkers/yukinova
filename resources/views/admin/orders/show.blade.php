@extends('layouts.admin')

@section('title','Order Details')

@section('content')
<div class="main-wrapper py-4">
    <div class="container-fluid">
        <h2 class="mb-4">Order #{{ $order->id }} Details</h2>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5>Billing Address</h5>
                        <p><strong>Name:</strong> {{ $order->name }}</p>
                        <p><strong>Email:</strong> {{ $order->email }}</p>
                        <p><strong>Phone:</strong> {{ $order->phone }}</p>
                        <p><strong>Address:</strong> {{ $order->address }}</p>
                        <p class="mb-0"><strong>Location:</strong> {{ $order->city }}, {{ $order->state }} - {{ $order->pincode }}</p>
                        @if($order->gstin)
                            <p class="mb-0 mt-2"><strong>GSTIN:</strong> {{ $order->gstin }}</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5>Shipping Address</h5>
                        @if($order->has_separate_shipping)
                            <p><strong>Name:</strong> {{ $order->shipping_name }}</p>
                            <p><strong>Phone:</strong> {{ $order->shipping_phone }}</p>
                            <p><strong>Address:</strong> {{ $order->shipping_address }}</p>
                            <p class="mb-0"><strong>Location:</strong> {{ $order->shipping_city }}, {{ $order->shipping_state }} - {{ $order->shipping_pincode }}</p>
                        @else
                            <p class="text-muted">Same as billing address</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <h5>Order Items</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th>Serial Number</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product->name ?? 'Deleted Product' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>₹{{ number_format($item->price) }}</td>
                            <td>₹{{ number_format($item->price * $item->quantity) }}</td>
                            <td>{{ $item->serial_number ?? '—' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mt-3 fw-bold fs-5">
                    Total: ₹{{ number_format($order->total_amount) }}
                </div>

                <div class="mt-3">
                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                        @csrf
                        <div class="d-flex align-items-center gap-2 flex-wrap mb-3">
                            <select name="status" id="order-status-select" class="form-select d-inline-block" style="width: auto;">
                                <option value="pending" {{ $order->status=='pending' ? 'selected' : '' }}>Pending</option>
                                <option value="dispatched" {{ $order->status=='dispatched' ? 'selected' : '' }}>Dispatched</option>
                                <option value="completed" {{ $order->status=='completed' ? 'selected' : '' }}>Completed</option>
                                <option value="canceled" {{ $order->status=='canceled' ? 'selected' : '' }}>Canceled</option>
                            </select>
                            <button class="btn btn-success">Update Status</button>

                            @if($order->invoice_number && in_array($order->status, ['dispatched', 'completed']))
                                <a href="{{ route('invoice.download', $order->id) }}" class="btn btn-outline-success">
                                    <i class="fas fa-file-pdf me-1"></i> Download Invoice
                                </a>
                            @endif
                        </div>

                        {{-- Serial number inputs (shown when dispatched is selected) --}}
                        <div id="serial-numbers-section" style="display: none;">
                            <div class="card bg-light p-3 mb-2">
                                <h6 class="fw-bold mb-3">Enter Serial Numbers for Each Item</h6>
                                @foreach($order->items as $item)
                                    <div class="mb-2">
                                        <label class="form-label mb-1">
                                            {{ $item->product->name ?? 'Deleted Product' }}
                                        </label>
                                        <input type="text" name="serial_numbers[{{ $item->id }}]"
                                               class="form-control form-control-sm"
                                               value="{{ old('serial_numbers.' . $item->id, $item->serial_number) }}"
                                               placeholder="Enter serial number">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelect = document.getElementById('order-status-select');
        const serialSection = document.getElementById('serial-numbers-section');

        function toggleSerialNumbers() {
            serialSection.style.display = statusSelect.value === 'dispatched' ? 'block' : 'none';
        }

        toggleSerialNumbers();
        statusSelect.addEventListener('change', toggleSerialNumbers);
    });
</script>
@endsection
