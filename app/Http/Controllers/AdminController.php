<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\OrganizationApproval;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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

        // return response()->json([
        //     'pending' => $pending,
        //     'approved' => $approved,
        //     'rejected' => $rejected,
        //     'organizationApproval' => $organizationApproval,
        // ]);
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
                'message' => 'Oh dear, Organization rejected! Please try tp reapply!'
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

        if ($admin->role !== 'admin') {
            abort(403); // Prevent others from accessing
        }

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
}
