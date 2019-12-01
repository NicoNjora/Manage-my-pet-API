<?php

namespace App\Http\Controllers;

use App\Dog;
use App\Vaccine;
use Illuminate\Http\Request;

class DogVaccineController extends Controller
{
    public function store(Request $request)
    {
        // TODO: Complete this with save logic for vaccine and dog pivot table
        $vaccine = Vaccine::where('id', $request['vaccine_id'])->first();
        $dog = auth()->user()->dogs()->find($request['dog_id']);
    
        if (!$vaccine) {
            return response()->json([
                'success' => false,
                'message' => 'Vaccine with id ' . $id . ' not found'
            ], 400);
        }

        $dog->vaccines()->sync($vaccine, false);
        $dog->vaccines()->getRelatedIds();

        return response()->json([
            'success' => true,
            'data' => $dog->toArray()
        ]);
    }
}
