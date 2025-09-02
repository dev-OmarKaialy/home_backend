@include('components.header', ['title' => 'Add Service'])

<body>

    <div class="page-wrapper" style="height: 100%; overflow: hidden;">
        @include('components.header-mobile')
        @include('components.sidebare')

        <div class="page-container">
            @include('components.header-desktop')

            <div class="container py-5" style="margin-top: 50px;">
                <h2 class="mb-4 text-center">Create New Service</h2>

                <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Service Name:</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description:</label>
                        <textarea name="description" id="description" rows="4" class="form-control"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="provider_id" class="form-label">Provider:</label>
                        <select name="provider_id" id="provider_id" class="form-select" required>
                            @foreach ($providers as $provider)
                            <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category:</label>
                        <select name="category_id" id="category_id" class="form-select" required>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <hr class="my-4">

                    <div class="mb-4">
                        <label for="image" class="form-label">Upload Image:</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
                        <small class="text-muted">Select one image file.</small>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-4">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('components.js-script')
</body>

</html>