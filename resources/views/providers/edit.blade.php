@include('components.header', ['title' => 'Edit Provider'])

<body>
    <div class="page-wrapper" style="height: 100%; overflow: hidden;">
        @include('components.header-mobile')
        @include('components.sidebare')

        <div class="page-container">
            @include('components.header-desktop')

            <div class="container py-5">
                <h2 class="mb-4 text-center" style="padding-top: 40px;">Edit Provider Details</h2>

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('providers.update', $provider->id) }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name:</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $provider->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" name="username" id="username" class="form-control" value="{{ old('username', $provider->username) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="text" name="password" id="password" class="form-control">
                        <p>leave empty if not change</p>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $provider->email) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone:</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $provider->phone) }}">
                    </div>

                    <div class="mb-3">
                        <label for="hourly_rate" class="form-label">Hourly Rate ($):</label>
                        <input type="number" name="hourly_rate" id="hourly_rate" class="form-control" value="{{ old('hourly_rate', $provider->hourly_rate) }}" step="0.01">
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="start_date" class="form-label">Start Date:</label>
                            <input type="date" name="start_date" id="start_date" class="form-control"
                                value="{{ old('start_date', $provider->start_date)}}">
                        </div>
                        <div class="col-md-6">
                            <label for="end_date" class="form-label">End Date:</label>
                            <input type="date" name="end_date" id="end_date" class="form-control"
                                value="{{ old('end_date', $provider->end_date) }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status:</label>
                        <select name="status" id="status" class="form-select">
                            <option value="active" {{ old('status', $provider->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $provider->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <hr class="my-4">

                    <div class="mb-4">
                        <label class="form-label">Current Profile Image:</label>
                        <div class="row">
                            <div class="col-md-4">
                                @if ($provider->getFirstMediaUrl('profile'))
                                <div class="card border-0 shadow-sm">
                                    <img src="{{ $provider->getFirstMediaUrl('profile') }}" class="card-img-top rounded" style="object-fit: cover; height: 150px;">
                                </div>
                                @else
                                <p class="text-muted">No profile image uploaded.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="image" class="form-label">Upload New Profile Image (Optional):</label>
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