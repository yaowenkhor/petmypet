<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\OrganizationApproval;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $user = Auth::user();

        $this->authorize('viewDashboard', $user);

        $pending = Organization::where('status', 'pending')->get();
        $approved = Organization::where('status', 'approved')->get();
        $rejected = Organization::where('status', 'rejected')->get();

        $organizationApproval = OrganizationApproval::all();

        return view("admin.home", compact("pending", "approved", "rejected", "organizationApproval"));
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
}
