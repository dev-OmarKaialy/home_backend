@include('components.header', ['title' => 'Join Requests'])

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
                            <i class="zmdi zmdi-account-calendar"></i> Join Requests
                        </h3>
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

                            .badge-pending {
                                background-color: #ffc107;
                            }

                            .badge-accepted {
                                background-color: #28a745;
                            }

                            .badge-rejected {
                                background-color: #dc3545;
                            }

                            .table-data {
                                height: 700px;
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
                                    <th>Full Name</th>
                                    <th>Address</th>
                                    <th>Field</th>
                                    <th>CV</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($requests as $request)
                                <tr>
                                    <td>{{ $request->full_name }}</td>
                                    <td>{{ $request->address }}</td>
                                    <td>{{ $request->field }}</td>
                                    <td>
                                        <a href="{{ asset('storage/' . $request->cv) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                            View CV
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $request->status }}">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            @if($request->status === 'pending')
                                            <form method="POST" action="{{ route('admin.join_requests.accept', $request->id) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-success" data-toggle="tooltip" title="Accept">
                                                    <i class="zmdi zmdi-check">Accept</i>
                                                </button>
                                            </form>
                                            @endif
                                            <form method="POST" action="{{ route('admin.join_requests.destroy', $request->id) }}" onsubmit="return confirm('Are you sure you want to delete this request?')">
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