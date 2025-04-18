<?php

namespace App\Http\Controllers;

// use App\Models\User;

use App\Models\AdoptionRequest;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;

class AdoptionController extends Controller
{
    function adpotion_list(){
        $requests=AdoptionRequest::all();
        return view('pet_list',[
         'requests'=>$requests,
        ]);
    }
}
