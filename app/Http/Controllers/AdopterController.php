<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdoptionApplication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class AdopterController extends Controller
{
    public function index(){
        return view("adopter.home");
    }

    //Submit Application Function 
    public function submitApplication(Request $request)
    {
        // Validate
        $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'living_situation' => 'required',
            'experience' => 'required',
        ]);
    
        $data = $request->only(['pet_id', 'living_situation', 'experience']);
        $data['adopter_id'] = Auth::id();
        $data['status'] = 'pending';
    
        // Create record
        AdoptionApplication::create($data);
    
        // Redirect
        //return redirect()->back()->with('success', 'Application submitted.');
    }

    // Show profile of currently logged-in adopter
    public function showProfile()
    {
        $user = Auth::user();
        return view('adopter.profile', ['user' => $user]);
    }

    // Show edit form for adopter profile
    public function showEditProfile($id)
    {
        $user = User::find($id);
    
        if (!$user || Auth::id() != $id) {
            return redirect()->route('adopter.home')->with('error', 'Unauthorized access.');
        }
    
        return view('adopter.editProfile', ['user' => $user]);
    }
    

    // Handle profile update for adopter
    public function editProfile(Request $req, $id)
    {
        $user = User::find($id);
    
        if (!$user) {
            return redirect('adopter/profile/' . $id)->with('error', 'User not found');
        }
    
        if (Auth::id() != $id) {
            return redirect('adopter/home')->with('error', 'Unauthorized action.');
        }
    
        $req->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $user->name = $req->name;
        $user->email = $req->email;
        $user->phone_number = $req->phone_number;
    
        if ($req->hasFile('image')) {
            // Delete old image if exists
            if ($user->image_path && file_exists(public_path('avatars/' . $user->image_path))) {
                unlink(public_path('avatars/' . $user->image_path));
            }
    
            // Upload new image
            $image = $req->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('avatars'), $imageName);
            $user->image_path = $imageName;
        }
    
        $user->save();
    
        return redirect('adopter/profile/' . $id)->with('success', 'Profile updated successfully');
    }
    
    
}    
