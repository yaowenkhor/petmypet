@extends('layouts.auth')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-1 rounded shadow-sm">
                <div class="card-header bg-white text-center">
                    <h2 class="text-primary fw-bold" style="font-size: 30px; padding-top: 20px; padding-bottom: 15px;">
                        {{ __('Edit Profile') }}
                    </h2>
                </div>

                <div class="card-body p-5">
                    @if (session('success'))
                        <div class="alert alert-success text-center" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger text-center" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('organization.edit') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Organization Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ old('phone_number', $user->phone_number) }}">
                            @error('phone_number')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control"  placeholder="Enter new password">
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"  placeholder="Confirm new password">
                            @error('password_confirmation')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="details" class="form-label">Details</label>
                            <textarea name="details" id="details" class="form-control" rows="4" required>{{ old('details', $user->organization->details) }}</textarea>
                            @error('details')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea name="address" id="address" class="form-control" rows="3" required>{{ old('address', $user->organization->address) }}</textarea>
                            @error('address')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image_path" class="form-label">Profile Image</label>
                            <input type="file" name="image_path" id="image_path" class="form-control">
                            @error('image_path')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <br><br>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-outline-primary">Save Changes</button>
                            <a href="{{ route('organization.home') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection