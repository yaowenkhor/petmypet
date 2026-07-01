@extends('layouts.master')

@section('page-specific-css')
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
@endsection


@section('title', 'Select Role')

@section('content')

    <div class="role-container">
        <h2>Please select your role</h2>
        <p>Choose how you want to log in</p>

        <form method="GET" action="{{ route('login.select.role') }}" id="roleForm">
            <div>
                <button type="submit" name="role" value="organization" class="role-option">
                    <img src="https://img.icons8.com/ios-filled/50/briefcase.png" alt="Organization">
                    <span>Organization</span>
                </button>

                <button type="submit" name="role" value="adopter" class="role-option">
                    <img src="https://img.icons8.com/ios-filled/50/user.png" alt="Adopter">
                    <span>Adopter</span>
                </button>

                <button type="submit" name="role" value="admin" class="role-option">
                    <img src="https://img.icons8.com/?size=100&id=52233&format=png&color=000000" alt="Adopter">
                    <span>Admin</span>
                </button>
            </div>
        </form>
    </div>

@endsection
