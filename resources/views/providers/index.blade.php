@include('components.header', ['title' => 'Providers'])

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
            padding-bottom: 2px;
        }

        .table td,
        .table th {
            vertical-align: middle;
            padding: 12px 40px;
            color: #333;
        }

        .table thead th {
            background-color: #f7f7f7;
            font-weight: 600;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 0.9rem;
            color: white;
        }

        .badge-active {
            background-color: #28a745;
        }

        .badge-inactive {
            background-color: #dc3545;
        }

        .table-data {
            height: 480px;
        }
    </style>

    <div class="page-wrapper" style="height: 100%; overflow: hidden;">
        @include('components.header-mobile')
        @include('components.sidebare')

        <div class="page-container">
            @include('components.header-desktop')

            <div class="main-content" style="padding-top: 60px;">
                <div class="user-data">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="title-3 m-b-0">
                            <i class="zmdi zmdi-accounts"></i> Providers Data
                        </h3>

                        <a href="{{ route('providers.create') }}" class="btn btn-primary" style="margin: 5px 30px">
                            <i class="zmdi zmdi-plus"></i> Add Provider
                        </a>
                    </div>

                    <div class="table-responsive table-data">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Provider</th>
                                    <th>Contact</th>
                                    <th>Hourly Rate</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($providers as $provider)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $provider->getFirstMediaUrl('profile_photo') ?: asset('images/default-avatar.png') }}"
                                                alt="profile" width="50" height="50" class="rounded-circle mr-2">
                                            <div>
                                                <strong>{{ $provider->name }}</strong><br>
                                                <small>{{ $provider->username }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <small>Email: {{ $provider->email }}</small><br>
                                            <small>Phone: {{ $provider->phone }}</small>
                                        </div>
                                    </td>
                                    <td>${{ number_format($provider->hourly_rate, 2) }}</td>
                                    <td>
                                        <span class="badge {{ $provider->status === 'active' ? 'badge-active' : 'badge-inactive' }}">
                                            {{ ucfirst($provider->status ?? 'inactive') }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="{{ route('providers.show', $provider->id) }}" class="btn btn-sm btn-primary">
                                                View
                                            </a>
                                            <a href="{{ route('providers.edit', $provider->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="zmdi zmdi-edit"> Edit</i>
                                            </a>
                                            <form method="POST" action="{{ route('providers.destroy', $provider->id) }}" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="zmdi zmdi-delete"> Delete</i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No providers found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="user-data__footer d-flex justify-content-center">
                        {{ $providers->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('components.js-script')
</body>

</html>