@include('components.header', ['title' => 'Add Provider'])

<body>
    <div class="page-wrapper" style="height: 100%; overflow: hidden;">
        @include('components.header-mobile')
        @include('components.sidebare')

        <div class="page-container">
            @include('components.header-desktop')

            <div class="container py-5" style="margin-top: 50px;">
                <h2 class="mb-4 text-center">Create New Provider</h2>

                <form action="{{ route('providers.store') }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name:</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                        @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" name="username" id="username" class="form-control" value="{{ old('username') }}" required>
                        @error('username') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="text" name="password" id="password" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                        @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone:</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" required>
                        @error('phone') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="service_id" class="form-label">Service:</label>
                            <select name="service_id" id="service_id" class="form-select" required>
                                @foreach ($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="category_id" class="form-label">Category:</label>
                            <select name="category_id" id="category_id" class="form-select" required>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="start_date" class="form-label">Start Date:</label>
                            <input type="date" name="start_date" id="start_date" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="end_date" class="form-label">End Date:</label>
                            <input type="date" name="end_date" id="end_date" class="form-control">
                        </div>
                    </div>


                    <div class="mb-3">
                        <label for="hourly_rate" class="form-label">Hourly Rate ($):</label>
                        <input type="number" step="0.01" name="hourly_rate" id="hourly_rate" class="form-control" value="{{ old('hourly_rate') }}">
                        @error('hourly_rate') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password (Optional):</label>
                        <input type="password" name="password" id="password" class="form-control">
                        @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status:</label>
                        <select name="status" id="status" class="form-select">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <hr class="my-4">

                    <div class="mb-4">
                        <label for="profile_photo_path" class="form-label">Upload Profile Photo:</label>
                        <input type="file" name="profile_photo_path" id="profile_photo_path" class="form-control" accept="image/*">
                        <small class="text-muted">Select a profile image (JPEG, PNG, JPG, WEBP).</small>
                        @error('profile_photo_path') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-4">Create Provider</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('components.js-script')
</body>

</html>