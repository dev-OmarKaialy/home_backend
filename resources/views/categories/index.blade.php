@include('components.header', ['title' => 'Categories'])

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
                            <i class="zmdi zmdi-account-calendar"></i> Categories Data
                        </h3>

                        <a href="{{ route('categories.create') }}" class="btn btn-primary" style="margin: 5px 30px">
                            <i class="zmdi zmdi-plus"></i> Add Category
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
                                    <th>Title</th>
                                    <th>Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                <tr>
                                    <td>
                                        <div>
                                            {{ $category->name }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                @if($category->getFirstMediaUrl('categories'))
                                                <div class="card border-0 shadow-sm">
                                                    <img
                                                        src="{{ $category->getFirstMediaUrl('categories') }}"
                                                        alt="Service image"
                                                        class="card-img-top rounded"
                                                        style="object-fit: cover; height: 60px;">
                                                </div>
                                                @else
                                                <p class="text-muted">No image available.</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" title="Edit">
                                                <i class="zmdi zmdi-edit">Edit</i>
                                            </a>
                                            <form method="POST" action="{{ route('categories.destroy', $category->id) }}" onsubmit="return confirm('Are you sure?')">
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
<!-- end document-->