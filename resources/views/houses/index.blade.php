@include('components.header', ['title' => 'Houses'])

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
                            <i class="zmdi zmdi-account-calendar"></i> Houses Data
                        </h3>

                        <a href="{{ route('houses.create') }}" class="btn btn-primary" style="margin: 5px 30px">
                            <i class="zmdi zmdi-plus"></i> Add House
                        </a>
                    </div>

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

                            .badge-unavailable {
                                background-color: #a72828ff;
                            }

                            .badge-available {
                                background-color: #5507ffff;
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
                                    <th>Address</th>
                                    <th>Price</th>
                                    <th>Details</th>
                                    <th>Status</th>
                                    <th>Views</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($houses as $house)
                                <tr>
                                    <td>
                                        <div>
                                            <strong>{{ $house->title }}</strong><br>
                                            <small>{{ Str::limit($house->description, 40) }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        @if($house->address)
                                        <div>
                                            <strong>{{ $house->address->city }}</strong><br>
                                            @if($house->address->region)
                                            <span>{{ $house->address->region }}</span><br>
                                            @endif
                                            @if($house->address->street)
                                            <span>Street: {{ $house->address->street }}</span><br>
                                            @endif
                                            @if($house->address->building)
                                            <span>Building: {{ $house->address->building }}</span>
                                            @endif
                                        </div>
                                        @else
                                        <em class="text-muted">No address</em>
                                        @endif
                                    </td>

                                    <td>${{ number_format($house->price, 2) }}</td>
                                    <td>
                                        <div>
                                            <strong>rooms number: {{ $house->rooms }}</strong><br>
                                            <span>space: {{ $house->space }}</span><br>
                                            <span>directions: {{ $house->directions }}</span><br>
                                        </div>
                                    </td>

                                    <td>
                                        @php
                                        $statusClass = match($house->status) {
                                        'rent' => 'rent',
                                        'sale' => 'sell',
                                        'unavailable' => 'unavailable',
                                        'available' => 'available',
                                        default => 'light',
                                        };
                                        @endphp
                                        <span class="badge badge-{{ $statusClass }}">
                                            {{ ucfirst($house->status) }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ $house->views_count }}
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="{{ route('houses.show', $house->id) }}" class="btn btn-sm btn-primary">
                                                View
                                            </a>
                                            <a href="{{ route('houses.edit', $house->id) }}" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" title="Edit">
                                                <i class="zmdi zmdi-edit">Edit</i>
                                            </a>
                                            <form method="POST" action="{{ route('houses.destroy', $house->id) }}" onsubmit="return confirm('Are you sure?')">
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
                        {{ $houses->links('pagination::bootstrap-4') }}
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