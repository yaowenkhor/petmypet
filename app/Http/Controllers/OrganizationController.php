<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\AdoptionApplication;

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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed', 'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',],
            'phone_number' => ['required', 'string', 'max:15'],
            'image_path' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'details' => ['required', 'string'],
            'address' => ['required', 'string'],
        ],[
            'password.regex' => 'Password must contain at least one letter, one number, and one special character.',
        ]);
    }

    public function index()
    {
        return view("organization.home");
    }

    public function reapply()
    {
        $user = Auth::guard('organization')->user();

        $organization = $user->organization;

        if ($organization->status == 'rejected') {
            $organization->status = 'pending';
            $organization->save();

            return response()->json("Reapplication submitted successfully!", 200);
            //return redirect()->back()->with('success', 'Reapplication submitted successfully!');
        } elseif ($organization->status == "pending") {
            return response()->json("Reapplication already submitted!", 400);
            //return redirect()->back()->with('error', 'Reapplication already submitted!');
        } elseif ($organization->status == "approved") {
            return response()->json("Organization already approved!", 400);
            //return redirect()->back()->with('error', 'Organization already approved!');
        }
    }

    public function displayEditProfileForm(){
        //return view('organization.edit', ['url' => 'organization']);
    }

    public function edit(Request $req){
        $user = Auth::guard('organization')->user();

        $organization = $user->organization;

        $this->authorize('update', $organization);

        $this->validator($req->all())->validate();

        try {
            $user->name = $req['name'];
            $user->email = $req['email'];
            $user->phone_number = $req['phone_number'];
            $user->password = bcrypt($req['password']);
            $user->save();

            $organization->details = $req['details'];
            $organization->address = $req['address'];
            $organization->save();

            return response()->json('Yay, Profile updated sucessfully',200);
            //return redirect()->back()->with('success', 'Yay, Profile updated sucessfully');

        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
            //return redirect()->back()->with('error', 'Oops, Something went wrong during resgistration ! Please try again!');
        }
    }

    //view all requests
    public function viewAdoptionRequests()
    {
        $organization = Auth::guard('organization')->user()->organization;

        // Get all requests for pets under this organization
        $requests = AdoptionApplication::where('organization_id', $organization->id)->with(['pet', 'adopter'])->get();

        return view('organization.adoptionRequests', ['requests' => $requests]);
    }

    public function updateAdoptionStatus(Request $request, $id)
    {
        // Validate incoming request
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'decision_message' => 'nullable|string|max:1000',
        ]);

        // Find the adoption application by ID
        $adoption = AdoptionApplication::with('pet')->find($id);

        // Check if the application exists
        if (!$adoption) {
            return redirect('organization/adoptionRequests')->with('error', 'Adoption request not found.');
        }

        // Get logged-in organization ID
        $organizationId = Auth::guard('organization')->user()->organization->id;

        // Ensure the organization owns the application
        if ($adoption->organization_id !== $organizationId) {
            return redirect('organization//adoptionRequests')->with('error', 'Unauthorized access.');
        }

        // Update the application status and optional message
        $adoption->status = $request->status;
        $adoption->decision_message = $request->decision_message;
        $adoption->save();

        // If approved, mark the pet as adopted and reject other pending requests
        if ($request->status === 'approved') {
            $pet = $adoption->pet;

            // Update pet status if it's still available
            if ($pet && $pet->status !== 'adopted') {
                $pet->status = 'adopted';
                $pet->save();
            }

            // Auto-reject all other pending applications for this pet
            AdoptionApplication::where('pet_id', $pet->id)
                ->where('id', '!=', $adoption->id)
                ->where('status', 'pending')
                ->update(['status' => 'rejected']);
        }

        // Return success message
        return redirect('organizatio/adoptionRequests')->with('success', 'Adoption request updated successfully.');
    }



}
