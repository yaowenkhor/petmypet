@extends('layouts.master')

@section('content')
    <div class="container py-5">
        <h2 class="text-center text-primary mb-4">My Profile</h2>

        {{-- Flash Message --}}
        @if (session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        <div class="row justify-content-center">
            <div class="col-md-8">

                {{-- Profile Info Card --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-body d-flex align-items-center">
                        {{-- Profile Picture --}}
                        <img src="{{ $user->image_path ? asset('storage/' . $user->image_path) : asset('images/default-profile.png') }}"
                            class="rounded-circle me-4" style="width: 100px; height: 100px; object-fit: cover;"
                            alt="Profile Picture">

                        {{-- Info --}}
                        <div>
                            <h4 class="mb-1">{{ $user->name }}</h4>
                            <p class="mb-1"><strong>Email:</strong> {{ $user->email }}</p>
                            <p class="mb-1"><strong>Phone:</strong> {{ $user->phone_number ?? '-' }}</p>
                            <p class="mb-0"><strong>Role:</strong> Adopter</p>
                        </div>
                    </div>
                </div>

                {{-- Adoption Applications --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">My Adoption Applications</h5>
                    </div>
                    <div class="card-body">
                        @if ($user->adopter && $user->adopter->application->isEmpty())
                            <p class="text-muted">You have not submitted any adoption applications yet.</p>
                        @else
                        <ul class="list-group">
                            @foreach ($user->adopter->application as $app)
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="mb-0">Pet: {{ $app->pet->name ?? 'Pet' }}</h6>
                                        <span class="badge {{ $app->status == 'pending' ? 'bg-warning text-dark' : ($app->status == 'approved' ? 'bg-success' : 'bg-danger') }}">
                                            {{ ucfirst($app->status) }}
                                        </span>
                                    </div>
                                    <div class="mt-2">
                                        <p class="mb-0"><strong>Organization's Message:</strong></p>
                                        <p class="text-muted mb-0 border-top pt-2">
                                            {{$app->decision_message ?? 'No message provided'}}
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                </div>

                {{-- Edit Profile --}}
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Edit Profile</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('adopter.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control"
                                    required>
                                @error('name')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                    class="form-control" required>
                                @error('email')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="phone_number" class="form-label">Phone Number</label>
                                <input type="text" name="phone_number"
                                    value="{{ old('phone_number', $user->phone_number) }}" class="form-control">
                                @error('phone_number')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="image_path" class="form-label">Profile Picture</label>
                                <input type="file" name="image_path" class="form-control">
                                @error('image_path')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="password" class="form-label">Enter new password / Enter your password to confirm changes</label>
                                <input type="password" name="password" class="form-control">
                                @error('password')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control">
                            </div>


                            <button type="submit" class="btn btn-info w-100">Update Profile</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection