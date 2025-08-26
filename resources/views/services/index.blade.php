@include('components.header', ['title' => 'Services'])

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
    </style>
    <div class="page-wrapper" style="height: 100%; overflow: hidden;">
        <!-- HEADER MOBILE-->
        @include('components.header-mobile')
        <!-- END HEADER MOBILE-->

        <!-- MENU SIDEBAR-->
        @include('components.sidebare')
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            @include('components.header-desktop')
            <!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            <div class="main-content" style="padding-top: 60px;">
                <!-- USER DATA-->
                <div class="user-data">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="title-3 m-b-0">
                            <i class="zmdi zmdi-account-calendar"></i> Services Data
                        </h3>

                        <a href="{{ route('services.create') }}" class="btn btn-primary" style="margin: 5px 30px">
                            <i class="zmdi zmdi-plus"></i> Add Service
                        </a>
                    </div>

                    {{-- Search Form Below --}}
                    <form method="GET" action="{{ route('services.index') }}" class="card p-3 mb-4 shadow-sm" style="margin: 0px 40px;">
                        <div class="row g-3 align-items-end">

                            {{-- Service Name --}}
                            <div class="col-md-4">
                                <label for="name" class="form-label">Service Name</label>
                                <input type="text" name="name" id="name" value="{{ request('name') }}" class="form-control" placeholder="Search by service name...">
                            </div>

                            {{-- Category --}}
                            <div class="col-md-4">
                                <label for="category_id" class="form-label">Category</label>
                                <select name="category_id" id="category_id" class="form-control">
                                    <option value="">Select category</option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Hourly Rate --}}
                            <div class="col-md-4">
                                <label for="hourly_rate" class="form-label">Max Hourly Rate ($)</label>
                                <input type="number" name="hourly_rate" id="hourly_rate" value="{{ request('hourly_rate') }}" class="form-control" placeholder="e.g. 50">
                            </div>

                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Search</button>
                            <a href="{{ route('services.index') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </form>


                    <div class="table-responsive table-data">
                        <style>
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

                            .badge-rent {
                                background-color: #ffc107;
                            }

                            .badge-sell {
                                background-color: #28a745;
                            }

                            .table-data {
                                height: 480px;
                            }

                            .table-data-feature a,
                            .table-data-feature button {
                                margin-right: 8px;
                            }

                            .table-data-feature i {
                                font-size: 18px;
                            }

                            .table-data-feature form {
                                display: inline;
                            }
                        </style>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Provider</th>
                                    <th>Orders Count</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($services as $service)
                                <tr>
                                    <td>
                                        <div>
                                            <strong>{{ $service->name }}</strong><br>
                                            <small>{{ Str::limit($service->description, 40) }}</small>
                                        </div>
                                    </td>

                                    <td>{{ $service->category->name }}</td>
                                    <td>
                                        @foreach($service->serviceProviders as $provider)
                                        {{ $provider->name }}<br>
                                        @endforeach
                                    </td>
                                    <td>
                                        {{ $service->orders_count }}
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="{{ route('services.show', $service->id) }}" class="btn btn-sm btn-primary">
                                                View
                                            </a>
                                            <a href="{{ route('services.edit', $service->id) }}" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" title="Edit">
                                                <i class="zmdi zmdi-edit">Edit</i>
                                            </a>
                                            <form method="POST" action="{{ route('services.destroy', $service->id) }}" onsubmit="return confirm('Are you sure?')">
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


                    </div>
                    <div class="user-data__footer d-flex justify-content-center">
                        {{ $services->links('pagination::bootstrap-4') }}
                    </div>
                </div>
                <!-- END USER DATA-->
            </div>
            <!-- END MAIN CONTENT-->
            <!-- END PAGE CONTAINER-->
        </div>

    </div>

    @include('components.js-script')

</body>

</html>
<!-- end document-->