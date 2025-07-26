@include('components.header', ['title' => 'House Details'])

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

    <div class="page-wrapper">
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
                    <h2 class="mb-0">{{ $house->title }}</h2>
                    <a href="{{ route('houses.edit', $house) }}" class="btn btn-primary">
                        <i class="zmdi zmdi-edit"></i> Edit
                    </a>
                </div>

                <div class="row row-cols-2 row-cols-md-3 g-3 mb-4">
                    @forelse ($house->getMedia('houses') as $media)
                    <div class="col">
                        <div class="card border-0 shadow-sm">
                            <img
                                src="{{ $media->getUrl() }}"
                                alt="House image"
                                class="card-img-top rounded"
                                style="object-fit: cover; height: 200px;">
                        </div>
                    </div>
                    @empty
                    <div class="col">
                        <p class="text-muted">No images available.</p>
                    </div>
                    @endforelse
                </div>

                <div class="card p-4">
                    <h5>Description:</h5>
                    <p>{{ $house->description }}</p>
                    <hr>


                    @if($house->address)
                    <h5>Address:</h5>
                    <p>
                        {{ $house->address->city }}
                        @if($house->address->region), {{ $house->address->region }}@endif
                        @if($house->address->street), {{ $house->address->street }}@endif
                        @if($house->address->building), Building: {{ $house->address->building }}@endif
                    </p>
                    <hr>
                    @endif

                    <h5>Price:</h5>
                    <p>{{ $house->price }} $</p>
                    <hr>

                    <h5>Status:</h5>
                    <p>{{ ucfirst($house->status) }}</p>
                    <hr>

                    <h5>Views:</h5>
                    <p>{{ $house->views_count }}</p>
                </div>
            </div>
            <!-- END MAIN CONTENT-->
        </div>
        <!-- END PAGE CONTAINER-->
    </div>

    @include('components.js-script')
</body>

</html>