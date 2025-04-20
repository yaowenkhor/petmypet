<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdoptionApplication;
use Illuminate\Support\Facades\Auth;
use App\Models\Pet;
use Storage;


class AdopterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:adopter');
    }

    public function index()
    {
        $user = Auth::user()->load('adopter.application');
        return view("adopter.home", compact("user"));
    }

    //Submit Application Function 
    public function submitApplication(Request $request, $id)
    {
        $user = Auth::user();
        $pet = Pet::findOrFail($id);

        if ($pet->status != 'available') {
            return redirect()->back()->with('error', 'This pet is not available for adoption.');
        }

        $existingApplication = AdoptionApplication::where('adopter_id', $user->id)
            ->where('pet_id', $id)
            ->first();

        if ($existingApplication) {
            return redirect()->back()->with('error', 'You have already submitted an application for this pet.');
        }

        if ($pet) {

            $organization = $pet->organization;
            $organization_id = $organization->id;
            $data['adopter_id'] = $user->id;
            $data['pet_id'] = $pet->id;
            $data['organization_id'] = $organization_id;
            $data['question'] = $request->question;

            AdoptionApplication::create($data);

            return redirect()->back()->with('success', 'Application submitted.');
        }
    }

    public function showEditProfile()
    {
        $user = Auth::user()->load('adopter');

        //return response()->json($user);
        return view('adopter.home', compact('user'));
    }


    public function editProfile(Request $req)
    {
        $user = Auth::user();
        $req->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',
            'phone_number' => 'nullable|string|max:20',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $image = $req->file('image_path');

        if ($image) {
            if ($user->image_path != null) {
                Storage::disk('public')->delete($user->image_path);
            }
            $path = $image->store('profile_images', 'public');
            $user->image_path = $path;
            logger("Image uploaded: " . $path);
        }

        $user->name = $req->name;
        $user->email = $req->email;
        $user->phone_number = $req->phone_number;
        $user->password = bcrypt($req->password);
        $user->save();

        return redirect()->route('adopter.profile')->with('success', 'Profile updated successfully');
    }


}
