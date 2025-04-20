@extends('layouts.master')

@section('page-specific-css')
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
@endsection


@section('title', 'Select Role')

@section('content')

    <div class="role-container">
        <h2>Please select your role</h2>
        <p>Choose how you want to log in</p>

        <form method="GET" action="{{ route('login.select.role') }}" id="roleForm">
            @csrf
            <input type="hidden" name="role" id="selectedRole">
            <div>
                <div class="role-option" data-role="organization">
                    <img src="https://img.icons8.com/ios-filled/50/briefcase.png" alt="Organization">
                    <span>Organization</span>
                </div>

                <div class="role-option" data-role="adopter">
                    <img src="https://img.icons8.com/ios-filled/50/user.png" alt="Adopter">
                    <span>Adopter</span>
                </div>

                <div class="role-option" data-role="admin">
                    <img src="https://img.icons8.com/?size=100&id=52233&format=png&color=000000" alt="Adopter">
                    <span>Admin</span>
                </div>
            </div>

            <button type="submit" class="btn blue">Continue</button>
        </form>
    </div>

    <script>
        const options = document.querySelectorAll('.role-option');
        const selectedRole = document.getElementById('selectedRole');

        options.forEach(option => {
            option.addEventListener('click', () => {
                options.forEach(o => o.classList.remove('selected'));
                option.classList.add('selected');
                selectedRole.value = option.getAttribute('data-role');
            });
        });

        document.getElementById('roleForm').addEventListener('submit', function (e) {
            if (!selectedRole.value) {
                e.preventDefault();
                alert('Please select a role first.');
            }
        });
    </script>
@endsection