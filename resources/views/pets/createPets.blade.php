@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="text-center mb-4">Add a New Pet for Adoption</h2>

    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pet.create') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Pet Name --}}
        <div class="mb-3">
            <label for="name" class="form-label">Pet Name</label>
            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
        </div>

        {{-- Species --}}
        <div class="mb-3">
            <label for="species" class="form-label">Species</label>
            <select name="species" class="form-select" required>
                <option value="">-- Select Species --</option>
                <option value="dog" {{ old('species') == 'dog' ? 'selected' : '' }}>Dog</option>
                <option value="cat" {{ old('species') == 'cat' ? 'selected' : '' }}>Cat</option>
                <option value="other" {{ old('species') == 'other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>

        {{-- Breed --}}
        <div class="mb-3">
            <label for="breed" class="form-label">Breed</label>
            <input type="text" class="form-control" name="breed" value="{{ old('breed') }}" required>
        </div>

        {{-- Age --}}
        <div class="mb-3">
            <label for="age" class="form-label">Age</label>
            <input type="number" class="form-control" name="age" value="{{ old('age') }}" min="0" required>
        </div>

        {{-- Size --}}
        <div class="mb-3">
            <label for="size" class="form-label">Size</label>
            <input type="text" class="form-control" name="size" value="{{ old('size') }}" required>
        </div>

        {{-- Location --}}
        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" name="location" value="{{ old('location') }}" required>
        </div>

        {{-- Temperament (Optional) --}}
        <div class="mb-3">
            <label for="temperament" class="form-label">Temperament</label>
            <input type="text" class="form-control" name="temperament" value="{{ old('temperament') }}">
        </div>

        {{-- Medical History (Optional) --}}
        <div class="mb-3">
            <label for="medical_history" class="form-label">Medical History</label>
            <textarea class="form-control" name="medical_history" rows="3">{{ old('medical_history') }}</textarea>
        </div>

        {{-- Image Upload --}}
        <div class="mb-3">
            <label for="image_path" class="form-label">Upload Images (Max: 4)</label>
            <input type="file" class="form-control" name="image_path[]" multiple required>
            <small class="form-text text-muted">Accepted formats: jpeg, png, jpg, gif, svg. Max size: 2MB per image.</small>
        </div>

        {{-- Submit --}}
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Post Pet for Adoption</button>
        </div>
    </form>
</div>
@endsection
