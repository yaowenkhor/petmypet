<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdopterController extends Controller
{
    public function index(){
        return view("adopter.home");
    }
}
