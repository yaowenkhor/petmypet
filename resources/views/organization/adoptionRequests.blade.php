@extends('layouts.master')

@section('content')
    <div class="container py-5">
        <h2 class="text-center mb-4 text-primary fw-bold" style="font-size: 30px;">Adoption Requests</h2>

        <div class="text-center mb-4">
            <a href="{{ route('organization.home') }}" class="btn btn-outline-secondary">
                Back to Home
            </a>
        </div>

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

        @if ($requests->isEmpty())
            <p class="text-center text-muted">No adoption requests found.</p>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead style="color: white; background-color: indigo;">
                        <tr>
                            <th>#</th>
                            <th>Pet Name</th>
                            <th>Adopter Name</th>
                            <th>Reason for Adoption</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($requests as $index => $request)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $request->pet->name ?? 'N/A' }}</td>
                                <td>
                                    @if ($request->adopter && $request->adopter->user)
                                        {{ $request->adopter->user->name }}
                                    @else
                                        Unknown Adopter
                                    @endif
                                </td>
                                <td>{{ $request->question ?? 'No reason provided' }}</td>
                                <td>
                                    <span
                                        class="badge 
                                        {{ $request->status === 'pending' ? 'bg-warning' : ($request->status === 'approved' ? 'bg-success' : 'bg-danger') }}">
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </td>
                                <td>
                                    <!-- Update Button -->
                                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#updateStatusModal-{{ $request->id }}">
                                        Update
                                    </button>

                                    <!-- Update Status Modal -->
                                    <div class="modal fade" id="updateStatusModal-{{ $request->id }}" tabindex="-1"
                                        aria-labelledby="updateStatusModalLabel-{{ $request->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="updateStatusModalLabel-{{ $request->id }}">
                                                        Update Adoption Request Status
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form
                                                    action="{{ route('organization.updateAdoptionStatus', ['id' => $request->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <p>Update the status for the adoption request of
                                                            <strong>{{ $request->pet->name }}</strong> by
                                                            <strong>
                                                                @if ($request->adopter && $request->adopter->user)
                                                                    {{ $request->adopter->user->name }}
                                                                @else
                                                                    Unknown Adopter
                                                                @endif
                                                            </strong>.
                                                        </p>
                                                        <div class="mb-3">
                                                            <label for="status" class="form-label">Status</label>
                                                            <select class="form-select" id="status" name="status" required>
                                                                <option value="approved"
                                                                    {{ $request->status === 'approved' ? 'selected' : '' }}>
                                                                    Approved
                                                                </option>
                                                                <option value="rejected"
                                                                    {{ $request->status === 'rejected' ? 'selected' : '' }}>
                                                                    Rejected
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="decision_message" class="form-label">Decision
                                                                Message (Optional)</label>
                                                            <textarea class="form-control" id="decision_message"
                                                                name="decision_message" rows="3">{{ $request->decision_message }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-outline-primary">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection