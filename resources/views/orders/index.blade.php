@include('components.header', ['title' => 'Orders'])

<body>
    <style>
        body,
        html {
            height: 100%;
            overflow: hidden;
        }

        .page-wrapper,
        .page-container {
            height: 100%;
            overflow: hidden;
        }
    </style>

    <div class="page-wrapper">
        @include('components.header-mobile')
        @include('components.sidebare')

        <div class="page-container">
            @include('components.header-desktop')

            <div class="main-content" style="padding-top: 60px;">
                <div class="user-data">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="title-3 m-b-0">
                            <i class="zmdi zmdi-assignment"></i> Orders Data
                        </h3>
                    </div>

                    <div class="table-responsive table-data">
                        <style>
                            .table td,
                            .table th {
                                vertical-align: middle;
                                padding: 12px 30px;
                                color: #333;
                            }

                            .table thead th {
                                background-color: #f7f7f7;
                                font-weight: 600;
                            }

                            .badge {
                                padding: 6px 12px;
                                border-radius: 12px;
                                font-size: 0.85rem;
                                color: white;
                                text-transform: capitalize;
                            }

                            .badge.pending {
                                background-color: #ffc107;
                            }

                            .badge.approved {
                                background-color: #17a2b8;
                            }

                            .badge.rejected {
                                background-color: #dc3545;
                            }

                            .badge.confirmed {
                                background-color: #007bff;
                            }

                            .badge.completed {
                                background-color: #28a745;
                            }

                            .badge.unpaid {
                                background-color: #dc3545;
                            }

                            .badge.partially_paid {
                                background-color: #ffc107;
                            }

                            .badge.paid {
                                background-color: #28a745;
                            }
                        </style>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Service Provider</th>
                                    <th>House</th>
                                    <th>Status</th>
                                    <th>Payment</th>
                                    <th>Service Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->user->name ?? '-' }}</td>
                                    <td>{{ $order->serviceProviders->name ?? '-' }}</td>
                                    <td>{{ $order->house->title ?? '-' }}</td>
                                    <td><span class="badge {{ $order->status }}">{{ $order->status }}</span></td>
                                    <td><span class="badge {{ $order->payment_status }}">{{ $order->payment_status }}</span></td>
                                    <td>{{ $order->service_date ? \Carbon\Carbon::parse($order->service_date)->format('Y-m-d H:i') : '-' }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-primary">
                                                View
                                            </a>
                                            <form method="POST" action="{{ route('orders.destroy', $order->id) }}" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" data-toggle="tooltip" title="Delete">
                                                    <i class="zmdi zmdi-delete">Delete</i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- Pagination --}}
                        <div class="mt-3 d-flex justify-content-center">
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('components.js-script')
</body>

</html>