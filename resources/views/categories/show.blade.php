@include('components.header', ['title' => 'Service Details'])

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
            <div class="container mt-4" style="padding-top: 70px;">
                <div class="header-with-button">
                    <h2 class="mb-0">{{ $service->name }}</h2>
                    <a href="{{ route('services.edit', $service->id) }}" class="btn btn-primary">
                        <i class="zmdi zmdi-edit"></i> Edit
                    </a>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        @if($service->getFirstMediaUrl('services'))
                        <div class="card border-0 shadow-sm">
                            <img
                                src="{{ $service->getFirstMediaUrl('services') }}"
                                alt="Service image"
                                class="card-img-top rounded"
                                style="object-fit: cover; height: 300px;">
                        </div>
                        @else
                        <p class="text-muted">No image available.</p>
                        @endif
                    </div>
                </div>

                <div class="card p-4">
                    <h5>Description:</h5>
                    <p>{{ $service->description }}</p>
                    <hr>

                    <h5>Category:</h5>
                    <p>{{ $service->category->name ?? 'No category assigned' }}</p>
                </div>
            </div>
            <!-- END MAIN CONTENT-->
        </div>
        <!-- END PAGE CONTAINER-->
    </div>

    @include('components.js-script')
</body>

</html>