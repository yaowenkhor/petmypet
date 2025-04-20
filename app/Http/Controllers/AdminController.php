<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\OrganizationApproval;
use App\Models\Pet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        return view('admin.index');
    }
    public function organizationApplications()
    {
        $user = Auth::user();

        $this->authorize('viewDashboard', $user);

        $pending = Organization::where('status', 'pending')->with('user')->get();
        $approved = Organization::where('status', 'approved')->with('user')->get();
        $rejected = Organization::where('status', 'rejected')->with('user')->get();

        $organizationApproval = OrganizationApproval::all();

        return view("admin.organization", compact("pending", "approved", "rejected", "organizationApproval"));
    }

    public function approveOrganization($id)
    {
        $user = Auth::user();

        $this->authorize('manageStatus', $user);

        $organization = Organization::find($id);

        if ($organization && $organization->status == 'pending') {
            $organization->status = 'approved';
            $organization->save();

            OrganizationApproval::create([
                'organization_id' => $organization->id,
                'user_id' => $user->id,
                'status' => 'approved',
                'message' => 'Hooray, Organization approved!'
            ]);

            return redirect()->back()->with('success', 'Yay, Organization approved successfully!');
        } else if ($organization && $organization->status == "rejected") {

            return redirect()->back()->with('error', 'Oops, Organization already rejected!');
        } else if ($organization && $organization->status == "approved") {

            return redirect()->back()->with('error', 'Oops, Organization already approved!');
        }
    }

    public function rejectOrganization($id)
    {
        $user = Auth::user();

        $this->authorize('manageStatus', $user);

        $organization = Organization::find($id);

        if ($organization && $organization->status == 'pending') {
            $organization->status = 'rejected';
            $organization->save();

            OrganizationApproval::create([
                'organization_id' => $organization->id,
                'user_id' => $user->id,
                'status' => 'rejected',
                'message' => 'Organization rejected! Please try to reapply!'
            ]);

            return redirect()->back()->with('success', 'Yay, Organization approved successfully!');
        } else if ($organization && $organization->status == "approved") {

            return redirect()->back()->with('error', 'Oops, Organization already rejected!');
        } else if ($organization && $organization->status == "rejected") {

            return redirect()->back()->with('error', 'Oops, Organization already approved!');
        }
    }

    public function editProfile()
    {
        $admin = Auth::user();

        return view('admin.edit-profile', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        $admin = Auth::user();

        if ($admin->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;

        if ($request->filled('password')) {
            $admin->password = bcrypt($request->password);
        }

        $admin->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function deletePet($id)
    {
        $user = Auth::user();

        $this->authorize('deletePet', $user);

        $pet = Pet::findOrFail($id);

        // Delete associated images from storage
        foreach ($pet->images as $image) {
            if ($image->image_path && Storage::exists('public/' . $image->image_path)) {
                Storage::delete('public/' . $image->image_path);
            }
        }

        // Delete image records
        $pet->images()->delete();

        // Delete pet record
        $pet->delete();

        return redirect()->back()->with('success', 'Pet listing deleted successfully.');
    }
}
