@extends('layouts.master')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-1 rounded shadow-sm">
                    <div class="card-header bg-white text-center">
                        <h2 class="text-primary fw-bold" style="font-size: 30px; padding-top: 20px; padding-bottom: 15px;">
                            {{ __('Add New Pet') }}
                        </h2>
                    </div>

                    <div class="card-body p-5">
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

                        <form action="{{ route('pet.create') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Pet Name</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="species" class="form-label">Species</label>
                                <select name="species" class="form-control">
                                    <option value="dog" {{ old('species') == 'dog' ? 'selected' : '' }}>Dog</option>
                                    <option value="cat" {{ old('species') == 'cat' ? 'selected' : '' }}>Cat</option>
                                    <option value="other" {{ old('species') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('species')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="age" class="form-label">Age</label>
                                <input type="number" name="age" id="age" class="form-control"
                                    value="{{ old('age') }}" required>
                                @error('age')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="breed" class="form-label">Breed</label>
                                <input type="text" name="breed" id="breed" class="form-control"
                                    value="{{ old('breed') }}" required>
                                @error('breed')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="size" class="form-label">Size</label>
                                <input type="text" name="size" id="size" class="form-control"
                                    value="{{ old('size') }}" required>
                                @error('size')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" name="location" id="location" class="form-control"
                                    value="{{ old('location') }}" required>
                                @error('location')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="temperament" class="form-label">Temperament</label>
                                <input type="text" name="temperament" id="temperament" class="form-control"
                                    value="{{ old('temperament') }}" required>
                                @error('temperament')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="medical_history" class="form-label">Medical History</label>
                                <textarea name="medical_history" id="medical_history" class="form-control" rows="4">{{ old('medical_history') }}</textarea>
                                @error('medical_history')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="image_path" class="form-label">Pet Image</label>
                                <input type="file" name="image_path[]" id="image_path" class="form-control" multiple>
                                @error('image_path')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <br><br>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-outline-primary">Add Pet</button>
                                <a href="{{ route('organization.home') }}" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
