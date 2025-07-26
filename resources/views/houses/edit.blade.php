@include('components.header', ['title' => 'Edit House'])

<body>

    <div class="page-wrapper" style="height: 100%; overflow: hidden;">
        @include('components.header-mobile')
        @include('components.sidebare')

        <div class="page-container">
            @include('components.header-desktop')

            <div class="container py-5">
                <h2 class="mb-4 text-center" style="padding-top: 40px;">Edit House Details</h2>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('houses.update', $house->id) }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label">Title:</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $house->title) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description:</label>
                        <textarea name="description" id="description" rows="4" class="form-control">{{ old('description', $house->description) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label d-block">Address:</label>
                        <div class="row g-2">
                            <div class="col-md-3">
                                <input type="text" name="city" class="form-control" placeholder="City"
                                    value="{{ old('city', $house->address?->city) }}">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="region" class="form-control" placeholder="Region"
                                    value="{{ old('region', $house->address?->region) }}">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="street" class="form-control" placeholder="Street"
                                    value="{{ old('street', $house->address?->street) }}">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="building" class="form-control" placeholder="Building"
                                    value="{{ old('building', $house->address?->building) }}">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Price ($):</label>
                        <input type="number" name="price" id="price" class="form-control" value="{{ old('price', $house->price) }}" step="0.01" required>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status:</label>
                        <select name="status" id="status" class="form-select">
                            <option value="sale" {{ $house->status == 'sale' ? 'selected' : '' }}>Sale</option>
                            <option value="rent" {{ $house->status == 'rent' ? 'selected' : '' }}>Rent</option>
                        </select>
                    </div>

                    <hr class="my-4">

                    <div class="mb-4">
                        <label class="form-label">Existing Images:</label>
                        <div class="row row-cols-2 row-cols-md-4 g-3">
                            @forelse ($house->getMedia('houses') as $media)
                            <div class="col">
                                <div class="card border-0 shadow-sm position-relative">
                                    <img src="{{ $media->getUrl() }}" class="card-img-top rounded" style="object-fit: cover; height: 50px;">
                                </div>
                            </div>
                            @empty
                            <p class="text-muted">No images uploaded.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="images" class="form-label">Upload New Images:</label>
                        <input type="file" name="image" id="images" class="form-control" multiple>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-4">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('components.js-script')
</body>

</html>