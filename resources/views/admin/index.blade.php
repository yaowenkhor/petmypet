@extends('layouts.master')

@section('page-specific-css')
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
@endsection

@section('content')
    <div class="container py-5">
        <h2 class="text-center mb-4 ">Admin Dashboard</h2>

        <div class="admin-dashboard">
            <a href="{{ route('admin.org.applications') }}" class="dashboard-button">
                🏢 Organization Applications
            </a>

            <a href="{{ route('pet.index') }}" class="dashboard-button">
                📄 Manage Pet Listings
            </a>

            <a href="{{ route('admin.profile.edit') }}" class="dashboard-button">
                🛠 Edit Profile
            </a>
        </div>
    </div>
@endsection