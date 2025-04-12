<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Pet;
use App\Models\PetsImage;
use Auth;
use Storage;

class PetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:organization')->except('index', 'show');
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


    public function create(Request $req)
    {
        $this->authorize('create', Pet::class);
        //return view('pets.create');
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
                return response()->json(['error' => 'No images uploaded.'], 400);
                //return redirect()->back()->with('error', 'Ehh, Please upload at least one image.');
            } else if ($req->hasFile('image_path') && count($req->file('image_path')) > 4) {
                return response()->json(['error' => 'You can upload a maximum of 4 images.'], 400);
                //return redirect()->back()->with('error', 'Ehh, You can upload a maximum of 4 images.');
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

            return response()->json($pet);
            //return redirect()->route('pets.index')->with('success', 'Yay! Your pet has been listed successfully.');

        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
            //return redirect()->back()->with('error', 'Oops! We couldn’t list your pet. Give it another shot!');
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

            return response()->json(['success' => 'Pet deleted successfully'], 200);
            //return redirect()->route('pets.index')->with('success', 'Yay! Your pet has been deleted successfully.');

        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
            //return redirect()->back()->with('error', 'Oops! We couldn’t delete your pet. Give it another shot!'); 
        }
    }

    public function displayPetUpdateForm($id)
    {
        $pet = Pet::findOrFail($id);
        $images = $pet->images;
        $this->authorize('update', $pet);

        return view("organization.editPet", compact('pet', 'images'));
    }

    public function update($id, Request $req)
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
                    //return response()->json(['error' => 'You can upload a maximum of 4 images.'], 400);
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

            return response()->json(['success' => 'Yup! Your pet has been updated successfully'], 200);
            //return redirect()->route('pets.index')->with('success', 'Yup! Your pet has been updated successfully');
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
            //return redirect()->back()->with('error', 'Oops! We couldn’t update your pet. Give it another shot!');
        }

    }


}
