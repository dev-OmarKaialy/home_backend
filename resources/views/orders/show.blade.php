@include('components.header', ['title' => 'Order Details'])

<body>
    <style>
        body,
        html {
            height: 100%;
            overflow-x: hidden;
            overflow-y: auto;

        }

        .header-with-button {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
    </style>

    <div class="page-wrapper">
        @include('components.header-mobile')
        @include('components.sidebare')

        <div class="page-container">
            @include('components.header-desktop')

            <div class="container mt-4" style="padding-top: 70px;">
                <div class="header-with-button">
                    <h2 class="mb-0">Order #{{ $order->id }}</h2>
                    <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" class="mb-3">
                        @csrf
                        @method('PUT')

                        <label for="status" class="form-label"><strong>Edit Status :</strong></label>
                        <div class="d-flex gap-2">
                            <select name="status" id="status" class="form-select w-auto">
                                @foreach(['pending', 'rejected','completed'] as $status)
                                <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                                @endforeach
                            </select>

                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>

                </div>

                <div class="card p-4 shadow-sm">
                    <h5>User:</h5>
                    <p>{{ $order->user->name ?? 'N/A' }}</p>
                    <hr>

                    <h5>Service Provider:</h5>
                    <p>{{ $order->serviceProviders->name ?? 'Not assigned' }}</p>
                    <hr>

                    <h5>House:</h5>
                    <p>{{ $order->house->title ?? 'Not linked to a house' }}</p>
                    <hr>

                    <h5>Status:</h5>
                    <p>
                        <span class="badge bg-{{ 
        $order->status === 'completed' ? 'success' : 
        ($order->status === 'rejected' ? 'danger' : 'warning') 
    }} text-white">
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>
                    <hr>

                    <h5>Payment Status:</h5>
                    <p>
                        <span class="badge bg-{{ 
        $order->payment_status === 'paid' ? 'success' : 
        ($order->payment_status === 'partially_paid' ? 'info' : 'secondary') 
    }} text-white">
                            {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                        </span>
                    </p>
                    <hr>


                    <h5>Service Date:</h5>
                    <p>{{ $order->service_date ? $order->service_date : 'Not scheduled' }}</p>
                    <hr>

                    <h5>Notes:</h5>
                    <p>{{ $order->notes ?? 'No notes provided' }}</p>
                </div>
            </div>
        </div>
    </div>

    @include('components.js-script')
</body>

</html>