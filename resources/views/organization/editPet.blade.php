@extends('layouts.auth')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit Pet') }}</div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('pet.update.submit', $pet->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group row mb-3">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Pet Name') }}</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ $pet->name ?? old('name') }}" required>
                                    @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="species"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Species') }}</label>
                                <div class="col-md-6">
                                    <select class="form-control @error('species') is-invalid @enderror" id="species"
                                        name="species" required>
                                        <option value="dog"
                                            {{ ($pet->species ?? old('species')) == 'dog' ? 'selected' : '' }}>Dog</option>
                                        <option value="cat"
                                            {{ ($pet->species ?? old('species')) == 'cat' ? 'selected' : '' }}>Cat</option>
                                        <option value="other"
                                            {{ ($pet->species ?? old('species')) == 'other' ? 'selected' : '' }}>Other
                                        </option>
                                    </select>
                                    @error('species')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="breed"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Breed') }}</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control @error('breed') is-invalid @enderror"
                                        id="breed" name="breed" value="{{ $pet->breed ?? old('breed') }}" required>
                                    @error('breed')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="age"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Age') }}</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control @error('age') is-invalid @enderror"
                                        id="age" name="age" value="{{ $pet->age ?? old('age') }}" required>
                                    @error('age')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="size"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Size') }}</label>
                                <div class="col-md-6">
                                    <select class="form-control @error('size') is-invalid @enderror" id="size"
                                        name="size" required>
                                        <option value="small"
                                            {{ ($pet->size ?? old('size')) == 'small' ? 'selected' : '' }}>Small</option>
                                        <option value="medium"
                                            {{ ($pet->size ?? old('size')) == 'medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="large"
                                            {{ ($pet->size ?? old('size')) == 'large' ? 'selected' : '' }}>Large</option>
                                    </select>
                                    @error('size')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="location"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Location') }}</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control @error('location') is-invalid @enderror"
                                        id="location" name="location" value="{{ $pet->location ?? old('location') }}"
                                        required>
                                    @error('location')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="temperament"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Temperament') }}</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control @error('temperament') is-invalid @enderror"
                                        id="temperament" name="temperament"
                                        value="{{ $pet->temperament ?? old('temperament') }}">
                                    <small class="form-text text-muted">e.g., 'friendly', 'shy', 'energetic'</small>
                                    @error('temperament')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="medical_history"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Medical History') }}</label>
                                <div class="col-md-6">
                                    <textarea class="form-control @error('medical_history') is-invalid @enderror" id="medical_history"
                                        name="medical_history" rows="3">{{ $pet->medical_history ?? old('medical_history') }}</textarea>
                                    @error('medical_history')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="status"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Status') }}</label>
                                <div class="col-md-6">
                                    <select class="form-control @error('status') is-invalid @enderror" id="status"
                                        name="status" required>
                                        <option value="available"
                                            {{ ($pet->status ?? old('status')) == 'available' ? 'selected' : '' }}>
                                            Available</option>
                                        <option value="adopted"
                                            {{ ($pet->status ?? old('status')) == 'adopted' ? 'selected' : '' }}>Adopted
                                        </option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="image_path"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Pet Images') }}</label>
                                <div class="col-md-6">
                                    <input type="file" class="form-control @error('image_path') is-invalid @enderror"
                                        id="image_path" name="image_path[]" multiple>
                                    <small class="form-text text-muted">You can upload up to 4 images. Uploading new images
                                        will replace existing ones.</small>
                                    @error('image_path')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    @if (session('error'))
                                        <div class="alert alert-danger mt-2">
                                            {{ session('error') }}
                                        </div>
                                    @endif

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
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">{{ __('Update Pet') }}</button>
                                    <a href="" class="btn btn-secondary">{{ __('Cancel') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
