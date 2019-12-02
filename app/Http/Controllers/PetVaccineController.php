<?php

namespace App\Http\Controllers;

use App\Pet;
use App\Vaccine;
use Illuminate\Http\Request;

class PetVaccineController extends Controller
{
    public function store(Request $request)
    {
        // TODO: Complete this with save logic for vaccine and pet pivot table
        $vaccine = Vaccine::where('id', $request['vaccine_id'])->first();
        $pet = auth()->user()->pets()->find($request['pet_id']);
    
        if (!$vaccine) {
            return response()->json([
                'success' => false,
                'message' => 'Vaccine with id ' . $id . ' not found'
            ], 400);
        }

        $pet->vaccines()->sync($vaccine, false);
        $pet->vaccines()->getRelatedIds();

        return response()->json([
            'success' => true,
            'data' => $pet->toArray()
        ]);
    }
}
