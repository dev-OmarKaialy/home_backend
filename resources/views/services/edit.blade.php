@include('components.header', ['title' => 'Edit Service'])

<body>

    <div class="page-wrapper" style="height: 100%; overflow: hidden;">
        @include('components.header-mobile')
        @include('components.sidebare')

        <div class="page-container">
            @include('components.header-desktop')

            <div class="container py-5">
                <h2 class="mb-4 text-center" style="padding-top: 40px;">Edit Service Details</h2>

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('services.update', $service->id) }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Service Name:</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $service->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description:</label>
                        <textarea name="description" id="description" rows="4" class="form-control">{{ old('description', $service->description) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="provider_id" class="form-label">Provider:</label>
                        <select name="provider_id" id="provider_id" class="form-select" required>
                            @foreach ($providers as $provider)
                            <option value="{{ $provider->id }}" {{ $service->provider_id == $provider->id ? 'selected' : '' }}>{{ $provider->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category:</label>
                        <select name="category_id" id="category_id" class="form-select" required>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $service->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <hr class="my-4">

                    <div class="mb-4">
                        <label class="form-label">Current Image:</label>
                        <div class="row">
                            <div class="col-md-4">
                                @if ($service->getFirstMediaUrl('service'))
                                <div class="card border-0 shadow-sm">
                                    <img src="{{ $service->getFirstMediaUrl('service') }}" class="card-img-top rounded" style="object-fit: cover; height: 150px;">
                                </div>
                                @else
                                <p class="text-muted">No image uploaded.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="image" class="form-label">Upload New Image (Optional):</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                        <small class="text-muted">Uploading a new image will replace the current one.</small>
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