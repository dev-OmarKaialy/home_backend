@include('components.header', ['title' => 'Provider Details'])

<body>
    <style>
        body,
        html {
            height: 100%;
            overflow-x: hidden;
        }

        .header-with-button {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
    </style>

    <div class="page-wrapper" style="height: 95%;">
        @include('components.header-mobile')
        @include('components.sidebare')

        <div class="page-container">
            @include('components.header-desktop')

            <div class="container mt-4" style="padding-top: 70px;">
                <div class="header-with-button">
                    <h2 class="mb-0">{{ $provider->name }}</h2>
                    <a href="{{ route('providers.edit', $provider->id) }}" class="btn btn-primary">
                        <i class="zmdi zmdi-edit"></i> Edit
                    </a>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        @if($provider->getFirstMediaUrl('profile'))
                        <div class="card border-0 shadow-sm">
                            <img
                                src="{{ $provider->getFirstMediaUrl('profile') }}"
                                alt="Provider image"
                                class="card-img-top rounded"
                                style="object-fit: cover; height: 300px;">
                        </div>
                        @else
                        <p class="text-muted">No profile photo available.</p>
                        @endif
                    </div>
                </div>

                <div class="card p-4 shadow-sm">
                    <h5>Username:</h5>
                    <p>{{ $provider->username }}</p>
                    <hr>

                    <h5>Email:</h5>
                    <p>{{ $provider->email }}</p>
                    <hr>

                    <h5>Phone:</h5>
                    <p>{{ $provider->phone }}</p>
                    <hr>

                    <h5>Hourly Rate:</h5>
                    <p>{{ $provider->hourly_rate ? '$' . $provider->hourly_rate : 'Not set' }}</p>
                    <hr>

                    <h5>Status:</h5>
                    <p>
                        <span class="badge {{ $provider->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                            {{ ucfirst($provider->status ?? 'inactive') }}
                        </span>
                    </p>
                    <hr>

                    <h5>Created At:</h5>
                    <p>{{ $provider->created_at->format('d M, Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    @include('components.js-script')
</body>

</html>