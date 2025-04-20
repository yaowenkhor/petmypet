<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Pet;
use App\Models\PetsImage;
use Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class PetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:organization')->except('index', 'displayDetails', 'search');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'species' => ['required', 'string', 'in:dog,cat,other'],
            'breed' => ['required', 'string'],
            'age' => ['required', 'integer', 'min:0'],
            'size' => ['required', 'string'],
            'location' => ['required', 'string'],
            'temperament' => ['nullable', 'string'],
            'medical_history' => ['nullable', 'string'],
        ]);
    }

    public function index()
    {
        if (!request()->cookie('visited')) {
            Cookie::queue('visited', true, 10 * 60); 
            $showGreeting = true;
        } else {
            $showGreeting = false;
        }

        $pets = Pet::with('images')->paginate(9);
        //return response()->json($pets);
        return view('pets.viewAllPets', compact('pets', 'showGreeting'));
    }

    public function displayDetails($id)
    {
        $pet = Pet::with('images')->findOrFail($id);

        return view('pets.viewPetDetails', ['pets' => $pet]);
    }

    public function search(Request $req)
    {
        if (!request()->cookie('visited')) {
            Cookie::queue('visited', true, 10 * 60); 
            $showGreeting = true;
        } else {
            $showGreeting = false;
        }

        $search_term = $req->query('term');

        $age_filter = $req->query('age') ? $req->query('age') : null;
        $status_filter = $req->query('status') ? $req->query('status') : null;

        $pets = Pet::query();

        if ($search_term != null) {
            $pets->where(function ($q) use ($search_term) {
                $q->where('name', 'LIKE', '%' . $search_term . '%')
                    ->orWhere('species', 'LIKE', '%' . $search_term . '%')
                    ->orWhere('breed', 'LIKE', '%' . $search_term . '%')
                    ->orWhere('location', 'LIKE', '%' . $search_term . '%')
                    ->orWhere('temperament', 'LIKE', '%' . $search_term . '%')
                    ->orWhere('medical_history', 'LIKE', '%' . $search_term . '%')
                    ->orWhere('size', 'LIKE', '%' . $search_term . '%', )
                    ->orWhere('age', 'LIKE', '%' . $search_term . '%');
            });
        }

        if ($age_filter != null) {
            $pets->orderBy('age', $age_filter);
        }

        if ($status_filter != null) {
            $pets->where('status', $status_filter);
        }

        $pets = $pets->with('images')->paginate(9);

        return view('pets.viewAllPets', compact('pets', 'showGreeting'));
    }

    public function show()
    {
        $user = Auth::user();
        $organization = $user->organization;

        $pets = $organization->pets()->with('images')->get();
;
        return view('pets.organizationPets', ['pets' => $pets]);
    }

    public function create()
    {
        $this->authorize('create', Pet::class);
        return view('pets.createPets');
    }

    public function store(Request $req)
    {
        $this->authorize('create', Pet::class);

        $this->validator($req->all())->validate();

        $user = Auth::user();
        $organization = $user->organization;

        try {
            $data = $req->all();
            $data['organization_id'] = $organization->id;

            if (!$req->hasFile('image_path')) {

                return redirect()->back()->withInput()->with('error', 'Ehh, Please upload at least one image.');
            } else if ($req->hasFile('image_path') && count($req->file('image_path')) > 4) {

                return redirect()->back()->withInput()->with('error', 'Ehh, You can upload a maximum of 4 images.');
            }

            $req->validate([
                'image_path.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $pet = Pet::create($data);

            $images = $req->file('image_path');// This an array of images , use image_path[] in the form

            foreach ($images as $image) {
                $path = $image->store('pet_images', 'public');
                PetsImage::create([
                    'pet_id' => $pet->id,
                    'image_path' => $path,
                ]);
            }

            return redirect()->route('pet.show')->with('success', 'Yay! Your pet has been listed successfully.');

        } catch (\Throwable $th) {

            return redirect()->back()->withInput()->with('error', 'Oops! We couldn’t list your pet. Give it another shot!');
        }
    }

    public function destroy($id)
    {

        $pet = Pet::findOrFail($id);
        $this->authorize('delete', $pet);

        try {
            if ($pet->images && $pet->images->count() > 0) {
                foreach ($pet->images as $image) {
                    Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                }
            }
            $pet->delete();

            return redirect()->route('pet.show')->with('success', 'Yay! Your pet has been deleted successfully.');

        } catch (\Throwable $th) {

            return redirect()->back()->with('error', 'Oops! We couldn’t delete your pet. Give it another shot!');
        }
    }

    public function displayPetUpdateForm($id)
    {
        $pet = Pet::findOrFail($id);
        $images = $pet->images;
        $this->authorize('update', $pet);

        return view("organization.editPet", compact('pet', 'images'));
    }

    public function update(Request $req, $id)
    {
        $pet = Pet::findOrFail($id);
        $this->authorize('update', $pet);

        try {
            $data = $req->all();
            $this->validator($data)->validate();

            if ($req->hasFile('image_path')) {

                $req->validate([
                    'image_path.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);

                $images = $req->file('image_path');// This an array of images , use image_path[] in the form

                if (count($images) > 4) {

                    return redirect()->back()->with('error', 'Ehh, You can upload a maximum of 4 images.');
                }

                if ($pet->images && $pet->images->count() > 0) {
                    foreach ($pet->images as $image) {
                        Storage::disk('public')->delete($image->image_path);
                        $image->delete();
                    }
                }

                foreach ($images as $image) {
                    $path = $image->store('pet_images', 'public');
                    PetsImage::create([
                        'pet_id' => $pet->id,
                        'image_path' => $path,
                    ]);
                }
            }
            $pet->update($data);


            return redirect()->route('pet.show')->with('success', 'Yup! Your pet has been updated successfully');
        } catch (\Throwable $th) {

            return redirect()->back()->with('error', 'Oops! We couldn’t update your pet. Give it another shot!');
        }

    }
}
