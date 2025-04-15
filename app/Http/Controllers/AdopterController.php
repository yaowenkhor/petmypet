<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdoptionApplication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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



}    
