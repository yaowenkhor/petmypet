<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Organization;
use App\Models\OrganizationApproval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        return view("admin.home");
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

            return response()->json("Organization approved successfully!", 200);
            //return redirect()->back()->with('success', 'Organization approved successfully!');
        } else if ($organization && $organization->status == "rejected") {
            return response()->json("Organization already rejected!", 400);
            //return redirect()->back()->with('error', 'Organization already rejected!');
        } else if ($organization && $organization->status == "approved") {
            return response()->json("Organization already approved!", 400);
            //return redirect()->back()->with('error', 'Organization already approved!');
        }
    }

    public function rejectOrganization($id){
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

            return response()->json("Organization rejected successfully!", 200);
            //return redirect()->back()->with('success', 'Organization approved successfully!');
        } else if ($organization && $organization->status == "approved") {
            return response()->json("Organization already approved!", 400);
            //return redirect()->back()->with('error', 'Organization already rejected!');
        } else if ($organization && $organization->status == "rejected") {
            return response()->json("Organization already rejected!", 400);
            //return redirect()->back()->with('error', 'Organization already approved!');
        }


    }
}
