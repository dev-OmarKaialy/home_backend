@include('components.header', ['title' => 'Wallet Transactions'])

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

        .badge {
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 0.9rem;
            color: white;
        }

        .badge-deposit {
            background-color: #007bff;
        }

        .badge-withdrawal {
            background-color: #dc3545;
        }

        .badge-pending {
            background-color: #ffc107;
        }

        .badge-approved {
            background-color: #28a745;
        }

        .badge-rejected {
            background-color: #6c757d;
        }

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
                            <i class="zmdi zmdi-balance-wallet"></i> Wallet Transactions
                        </h3>
                    </div>

                    <div class="table-responsive table-data" style="height: 700px;">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Reference</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->wallet->user->name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge badge-{{ $transaction->type === 'deposit' ? 'deposit' : 'withdrawal' }}">
                                            {{ ucfirst($transaction->type) }}
                                        </span>
                                    </td>
                                    <td>{{ number_format($transaction->amount, 2) }} $</td>
                                    <td>{{ $transaction->reference ?? '-' }}</td>
                                    <td>
                                        <span class="badge badge-{{ $transaction->status }}">
                                            {{ ucfirst($transaction->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $transaction->created_at }}</td>
                                    <td>
                                        @if ($transaction->status === 'pending')
                                        <form method="POST" action="{{ route('wallets.approve', $transaction->id) }}" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button class="btn btn-sm btn-success">Approve</button>
                                        </form>

                                        <form method="POST" action="{{ route('wallets.reject', $transaction->id) }}" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button class="btn btn-sm btn-danger">Reject</button>
                                        </form>
                                        @else
                                        <span class="text-muted">Handled</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('components.js-script')
</body>

</html>