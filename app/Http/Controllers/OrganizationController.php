<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\AdoptionApplication;
use Storage;

class OrganizationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:organization');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6', 'confirmed', 'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',],
            'phone_number' => ['required', 'string', 'max:15'],
            'image_path' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'details' => ['required', 'string'],
            'address' => ['required', 'string'],
        ], [
            'password.regex' => 'Password must contain at least one letter, one number, and one special character.',
        ]);
    }

    public function index()
    {
        $user = Auth::user()->load('organization.approvals');

        $organzation = $user->organization;

        $petCounts =  $organzation->pets()->count();

        return view("organization.home", compact('user', 'petCounts'));
    }

    public function reapply()
    {
        $user = Auth::guard('organization')->user();

        $organization = $user->organization;

        if ($organization->status == 'rejected') {
            $organization->status = 'pending';
            $organization->save();

            return redirect()->back()->with('success', 'Yay, Reapplication submitted successfully!');
        } elseif ($organization->status == "pending") {

            return redirect()->back()->with('error', 'Oops, Reapplication already submitted!');
        } elseif ($organization->status == "approved") {

            return redirect()->back()->with('error', 'Oops, Organization already approved!');
        }
    }

    public function displayEditProfileForm()
    {
        $user = Auth::guard('organization')->user();
        return view('organization.editProfile', ['user' => $user]);
    }

    public function edit(Request $req)
    {
        $user = Auth::guard('organization')->user();

        $organization = $user->organization;

        $this->authorize('update', $organization);

        $this->validator($req->all())->validate();

        try {
            $user->name = $req['name'];
            $user->email = $req['email'];
            $user->phone_number = $req['phone_number'];
            $user->password = bcrypt($req['password']);

            $image = $req->file('image_path');

            if ($image) {
                if ($user->image_path != null) {
                    Storage::disk('public')->delete($user->image_path);
                }
                $path = $image->store('profile_images', 'public');
                $user->image_path = $path;
            }

            $user->save();

            $organization->details = $req['details'];
            $organization->address = $req['address'];
            $organization->save();

            return redirect()->route('organization.home')->with('success', 'Yay, Profile updated sucessfully');

        } catch (\Throwable $th) {

            return redirect()->route('organization.home')->with('error', 'Oops, Something went wrong during resgistration ! Please try again!');
        }
    }

    //view all requests
    public function viewAdoptionRequests()
    {
        $organization = Auth::guard('organization')->user()->organization;

        $this->authorize('view', $organization);

        $requests = AdoptionApplication::where('organization_id', $organization->id)->with(['pet', 'adopter'])->get();

        return view('organization.adoptionRequests', compact('requests'));
    }

    public function updateAdoptionStatus(Request $request, $id)
    {

        $organization = Auth::guard('organization')->user()->organization;

        $this->authorize('update', $organization);

        $request->validate([
            'status' => 'required|in:approved,rejected',
            'decision_message' => 'nullable|string|max:1000',
        ]);

        $adoption = AdoptionApplication::with('pet')->find($id);

        if (!$adoption) {

            return redirect()->route('organization.adoptionRequests')->with('error', 'Opps, Adoption request not found.');
        }

        $adoption->status = $request->status;
        $adoption->decision_message = $request->decision_message;
        $adoption->save();

        if ($request->status === 'approved') {
            $pet = $adoption->pet;

            if ($pet && $pet->status !== 'adopted') {
                $pet->status = 'adopted';
                $pet->save();
            }

            AdoptionApplication::where('pet_id', $pet->id)
                ->where('id', '!=', $adoption->id)
                ->where('status', 'pending')
                ->update(['status' => 'rejected']);
        }
        return redirect()->route('organization.adoptionRequests')->with('success', 'Yay, Adoption request updated successfully.');
    }
}
