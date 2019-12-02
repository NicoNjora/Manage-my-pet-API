<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Breed;

class BreedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breeds = Breed::all();
 
        return response()->json($breeds);
    }
}
