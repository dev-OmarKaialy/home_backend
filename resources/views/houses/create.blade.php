@include('components.header', ['title' => 'Add House'])

<body>

    <div class="page-wrapper" style="height: 100%; overflow: hidden;">
        @include('components.header-mobile')
        @include('components.sidebare')

        <div class="page-container">
            @include('components.header-desktop')

            <div class="container py-5">
                <h2 class="mb-4 text-center">Create New House</h2>

                <form action="{{ route('houses.store') }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Title:</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description:</label>
                        <textarea name="description" id="description" rows="4" class="form-control"></textarea>
                    </div>


                    <div class="mb-3">
                        <label class="form-label d-block">Address:</label>
                        <div class="row g-2">
                            <div class="col-md-3">
                                <input type="text" name="city" class="form-control" placeholder="City">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="region" class="form-control" placeholder="Region">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="street" class="form-control" placeholder="Street">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="building" class="form-control" placeholder="Building">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Price ($):</label>
                        <input type="number" name="price" id="price" class="form-control" step="0.01" required>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status:</label>
                        <select name="status" id="status" class="form-select">
                            <option value="sale">Sale</option>
                            <option value="rent">Rent</option>
                        </select>
                    </div>

                    <hr class="my-4">

                    <div class="mb-4">
                        <label for="images" class="form-label">Upload New Image:</label>
                        <input type="file" name="image" id="images" class="form-control" multiple>
                        <small class="text-muted">Select one file.</small>
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