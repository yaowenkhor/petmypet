@extends('layouts.master')

@section('content')
    <div class="container py-5">
        <h2 class="text-center mb-4 ">Edit Profile</h2>

        {{-- Back Button --}}
        <div class="mb-4">
            <a href="{{ route('admin.home') }}" class="btn btn-outline-secondary">⬅ Back to Dashboard</a>
        </div>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.profile.update') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input name="name" class="form-control" value="{{ old('name', $admin->name) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input name="email" type="email" class="form-control" value="{{ old('email', $admin->email) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">New Password (optional)</label>
                <input name="password" type="password" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input name="password_confirmation" type="password" class="form-control">
            </div>

            <button type="submit" class="btn btn-info">Update Profile</button>
        </form>
    </div>
@endsection