@extends('layouts.master')

@section('content')
    <div class="container py-5">
        <h2 class="text-center  mb-4">Admin Dashboard</h2>
        <div class="text-start mb-4">
            <a href="{{ route('admin.home') }}" class="btn btn-outline-primary">
                ⬅ Back to Dashboard
            </a>
        </div>
        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger text-center">{{ session('error') }}</div>
        @endif

        {{-- Pending Organizations --}}
        <div class="card mb-4 shadow">
            <div class="card-header bg-warning">
                <h5 class="text-white mb-0">Pending Organization Applications</h5>
            </div>
            <div class="card-body">
                @if ($pending->isEmpty())
                    <p class="text-muted">No pending applications.</p>
                @else
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Details</th>
                                <th>Address</th>
                                <th>Submitted At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pending as $org)
                                <tr>
                                    <td>{{ $org->user->name }}</td>
                                    <td>{{ $org->user->email }}</td>
                                    <td>{{$org->details}}</td>
                                    <td>{{$org->address}}</td>
                                    <td>{{ $org->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <form action="{{ route('admin.approve', $org->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button class="btn btn-success btn-sm">Approve</button>
                                        </form>
                                        <form action="{{ route('admin.reject', $org->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button class="btn btn-danger btn-sm">Reject</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        {{-- Approved Organizations --}}
        <div class="card mb-4 shadow">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Approved Organizations</h5>
            </div>
            <div class="card-body">
                @if ($approved->isEmpty())
                    <p class="text-muted">No approved organizations.</p>
                @else
                    <ul class="list-group">
                        @foreach ($approved as $org)
                            <li class="list-group-item">{{ $org->user->name }} ({{ $org->user->email }})</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        {{-- Rejected Organizations --}}
        <div class="card mb-4 shadow">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">Rejected Organizations</h5>
            </div>
            <div class="card-body">
                @if ($rejected->isEmpty())
                    <p class="text-muted">No rejected organizations.</p>
                @else
                    <ul class="list-group">
                        @foreach ($rejected as $org)
                            <li class="list-group-item">{{ $org->user->name }} ({{ $org->user->email }})</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        {{-- Organization Approval Logs --}}
        <div class="card shadow">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">Approval History</h5>
            </div>
            <div class="card-body">
                @if ($organizationApproval->isEmpty())
                    <p class="text-muted">No approval history yet.</p>
                @else
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Organization</th>
                                <th>Action</th>
                                <th>By</th>
                                <th>Message</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($organizationApproval as $log)
                                <tr>
                                    <td>{{ $log->organization->user->name ?? 'N/A' }}</td>
                                    <td>{{ ucfirst($log->status) }}</td>
                                    <td>{{ $log->user->name ?? 'Admin' }}</td>
                                    <td>{{ $log->message }}</td>
                                    <td>{{ $log->created_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection