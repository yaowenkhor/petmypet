@extends('layouts.master')

@section('content')
    <div class="container py-5">
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

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-1 rounded shadow-sm">
                    <div class="card-header bg-white text-center">
                        <h2 class="text-primary fw-bold" style="font-size: 30px; padding-top: 20px; padding-bottom: 15px;">
                            {{ __('Organization Profile') }}
                        </h2>
                    </div>

                    <div class="card-body p-5">
                        <div class="d-flex flex-column align-items-center mb-4">
                            <img src="{{ $user->image_path ? asset('storage/' . $user->image_path) : asset('images/default-profile.png') }}"
                                alt="Profile Image" class="rounded-circle border border-3 border-primary" width="150"
                                height="150" style="object-fit: contain;">
                            <h4 class="mt-3 text-secondary">{{ $user->name }}</h4>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <tbody>
                                    <tr>
                                        <th class="bg-light w-25">Email</th>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Phone Number</th>
                                        <td>{{ $user->phone_number }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Details</th>
                                        <td>{{ $user->organization->details }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Address</th>
                                        <td>{{ $user->organization->address }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Status</th>
                                        <td>
                                            @php
                                                $status = strtolower($user->organization->status);
                                                $badgeClass = '';

                                                // Using if-else instead of match
                                                if ($status === 'approved') {
                                                    $badgeClass = 'bg-success';
                                                } elseif ($status === 'pending') {
                                                    $badgeClass = 'bg-warning text-dark';
                                                } elseif ($status === 'rejected') {
                                                    $badgeClass = 'bg-danger';
                                                } else {
                                                    $badgeClass = 'bg-secondary';
                                                }
                                            @endphp

                                            <div class="d-flex justify-content-between align-items-center w-100">
                                                <span class="badge {{ $badgeClass }} px-3 py-2">
                                                    {{ ucfirst($status) }}
                                                </span>

                                                <form action="{{ route('organization.reapply') }}" method="POST"
                                                    class="ms-3">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-secondary btn-sm">
                                                        Reapply
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Approval History</th>
                                        <td>
                                            @if(isset($user->organization->approvals) && count($user->organization->approvals) > 0)
                                                <ul class="list-group">
                                                    @foreach($user->organization->approvals as $approval)
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <span class="fw-bold">{{ ucfirst($approval->status ?? 'Unknown') }}</span>
                                                                @if(isset($approval->message))
                                                                    <p class="mb-0 text-muted">{{ $approval->message }}</p>
                                                                @endif
                                                            </div>
                                                            @if(isset($approval->created_at))
                                                                <span class="badge bg-secondary rounded-pill">{{ \Carbon\Carbon::parse($approval->created_at)->format('Y-m-d H:i') }}</span>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <span class="text-muted">No approval history available</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Pet Count</th>
                                        <td>
                                            <div class="d-flex justify-content-between align-items-center w-100">
                                                <span>{{ $petCounts }}</span>
                                                <div>
                                                    <a href="{{ route('pet.create.form') }}"
                                                        class="btn btn-outline-success btn-sm ms-3">
                                                        Create Pets
                                                    </a>
                                                    <a href="{{ route('pet.show') }}"
                                                        class="btn btn-outline-primary btn-sm ms-2">
                                                        View My Pets
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="text-center mt-4">
                            <a href="{{ route('organization.edit.form') }}" class="btn btn-outline-primary">
                                Edit Profile
                            </a>
                            <a href="{{ route('organization.adoptionRequests') }}" class="btn btn-outline-secondary ms-2">
                                View Adoption Requests
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
