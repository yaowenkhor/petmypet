@extends('layouts.auth')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-1 rounded shadow-sm">
                    <div class="card-header bg-white text-center">
                        <h2 class="text-primary fw-bold" style="font-size: 30px; padding-top: 20px; padding-bottom: 15px;">
                            {{ __('Edit Pet') }}
                        </h2>
                    </div>

                    <div class="card-body p-5">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger text-center" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('pet.update.submit', $pet->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">Pet Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ $pet->name ?? old('name') }}" required>
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="species" class="form-label">Species</label>
                                <select class="form-control @error('species') is-invalid @enderror" id="species"
                                    name="species" required>
                                    <option value="dog" {{ ($pet->species ?? old('species')) == 'dog' ? 'selected' : '' }}>Dog</option>
                                    <option value="cat" {{ ($pet->species ?? old('species')) == 'cat' ? 'selected' : '' }}>Cat</option>
                                    <option value="other" {{ ($pet->species ?? old('species')) == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('species')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="breed" class="form-label">Breed</label>
                                <input type="text" class="form-control @error('breed') is-invalid @enderror"
                                    id="breed" name="breed" value="{{ $pet->breed ?? old('breed') }}" required>
                                @error('breed')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="age" class="form-label">Age</label>
                                <input type="text" class="form-control @error('age') is-invalid @enderror"
                                    id="age" name="age" value="{{ $pet->age ?? old('age') }}" required>
                                @error('age')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="size" class="form-label">Size</label>
                                <select class="form-control @error('size') is-invalid @enderror" id="size"
                                    name="size" required>
                                    <option value="small" {{ ($pet->size ?? old('size')) == 'small' ? 'selected' : '' }}>Small</option>
                                    <option value="medium" {{ ($pet->size ?? old('size')) == 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="large" {{ ($pet->size ?? old('size')) == 'large' ? 'selected' : '' }}>Large</option>
                                </select>
                                @error('size')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" class="form-control @error('location') is-invalid @enderror"
                                    id="location" name="location" value="{{ $pet->location ?? old('location') }}" required>
                                @error('location')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="temperament" class="form-label">Temperament</label>
                                <input type="text" class="form-control @error('temperament') is-invalid @enderror"
                                    id="temperament" name="temperament" value="{{ $pet->temperament ?? old('temperament') }}">
                                <small class="form-text text-muted">e.g., 'friendly', 'shy', 'energetic'</small>
                                @error('temperament')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="medical_history" class="form-label">Medical History</label>
                                <textarea class="form-control @error('medical_history') is-invalid @enderror" id="medical_history"
                                    name="medical_history" rows="3">{{ $pet->medical_history ?? old('medical_history') }}</textarea>
                                @error('medical_history')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-control @error('status') is-invalid @enderror" id="status"
                                    name="status" required>
                                    <option value="available" {{ ($pet->status ?? old('status')) == 'available' ? 'selected' : '' }}>Available</option>
                                    <option value="adopted" {{ ($pet->status ?? old('status')) == 'adopted' ? 'selected' : '' }}>Adopted</option>
                                </select>
                                @error('status')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="image_path" class="form-label">Pet Images</label>
                                <input type="file" class="form-control @error('image_path') is-invalid @enderror"
                                    id="image_path" name="image_path[]" multiple>
                                <small class="form-text text-muted">You can upload up to 4 images. Uploading new images will replace existing ones.</small>
                                @error('image_path')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                @if (isset($images) && count($images) > 0)
                                    <div class="mt-3">
                                        <p>Current Images:</p>
                                        <div class="row">
                                            @foreach ($images as $image)
                                                <div class="col-6 mb-2">
                                                    <img src="{{ asset('storage/' . $image->image_path) }}"
                                                        alt="Pet Image" class="img-thumbnail"
                                                        style="width: 100%; max-height: 150px; object-fit: cover;">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <br><br>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-outline-primary">Update Pet</button>
                                <a href="{{ route('organization.home') }}" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
