@include('components.header', ['title' => 'Add Category'])

<body>

    <div class="page-wrapper" style="height: 100%; overflow: hidden;">
        @include('components.header-mobile')
        @include('components.sidebare')

        <div class="page-container">
            @include('components.header-desktop')

            <div class="container py-5" style="margin-top: 50px;">
                <h2 class="mb-4 text-center">Create New Category</h2>

                <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name:</label>
                        <input type="text" name="name" id="name" class="form-control" required>
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