@include('components.header', ['title' => 'Edit Category'])

<body>

    <div class="page-wrapper" style="height: 100%; overflow: hidden;">
        @include('components.header-mobile')
        @include('components.sidebare')

        <div class="page-container">
            @include('components.header-desktop')

            <div class="container py-5" style="margin-top: 50px;">
                <h2 class="mb-4 text-center">Edit Category</h2>

                <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name:</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $category->name) }}" required>
                    </div>

                    <hr class="my-4">

                    <div class="mb-4">
                        <label class="form-label">Current Image:</label><br>
                        <img src="{{ $category->getFirstMediaUrl('category') }}" alt="Current Image" class="img-thumbnail" style="max-height: 150px;">
                    </div>

                    <div class="mb-4">
                        <label for="image" class="form-label">Change Image (optional):</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                        <small class="text-muted">Leave empty to keep current image.</small>
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