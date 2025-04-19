@extends('layouts.master')

@section('content')
    <div class="container py-5">
        <h2 class="text-center mb-4 ">Admin Dashboard</h2>

        <div class="admin-dashboard">
            <a href="{{ route('admin.org.applications') }}" class="dashboard-button">
                🏢 Organization Applications
            </a>

            <a href="{{ route('admin.listings') }}" class="dashboard-button">
                📄 View Pet Listings
            </a>

            <a href="{{ route('admin.profile.edit') }}" class="dashboard-button">
                🛠 Edit Profile
            </a>
        </div>
    </div>
@endsection