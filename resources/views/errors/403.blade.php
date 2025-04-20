@extends('layouts.master')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 85vh;">
    <div class="p-5 text-center shadow-lg rounded-4 border border-light">
        <h1 class="display-1 fw-bold text-danger mb-4">403</h1>
        <h2 class="text-body-emphasis mb-3">You are unauthorized</h2>
        <p class="lead mb-4">
            Sorry, you couldn't access the page you're looking for.
        </p>
        <a href="{{route('pet.index') }}" class="btn btn-primary btn-lg px-4 shadow-sm" type="button">
            Go Home
        </a>
        <a href="{{ url()->previous() }}" class="btn btn-primary btn-lg px-4 shadow-sm" type="button">
            Go Back
        </a>
        <div class="mt-4">
            <img src="{{ asset('images/oops-facepalm.gif') }}" alt="Oops! Facepalm" class="img-fluid rounded-3 shadow">
        </div>
    </div>
</div>
@endsection
