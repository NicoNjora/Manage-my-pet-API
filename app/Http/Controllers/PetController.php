<?php

namespace App\Http\Controllers;

use App\Pet;
use Illuminate\Http\Request;
use App\Http\Resources\PetResourceCollection;
use App\Http\Resources\PetResource;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pets = auth()->user()->pets;
 
        // return new PetResourceCollection(auth()->user()->pets);
        return new PetResourceCollection(PetResource::collection(Pet::all()));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'date_born' => 'required|date',
            'category_id' => 'required|integer',
            'breed_id' => 'required|integer',
            'gender' => 'required|string'
        ]);

        if($request->hasFile('image')) {
            
            $file = $request->file('image');

            if(!$file->isValid()) {
                return response()->json(['invalid_file_upload'], 400);
            }

            // Local
            $file_name = 'pet-' . $request->breed . time() .'.'. $file->getClientOriginalExtension();
            $path = public_path() . '/uploads/pets/';
            $file->move($path, $file_name);

            $pet = new Pet();
            $pet->name = $request->name;
            $pet->breed_id = $request->breed_id;
            $pet->date_born = $request->date_born;
            $pet->color = $request->color;
            $pet->category_id = $request->category_id;
            $pet->gender = $request->gender;
            $pet->photo_url = $file_name;

            if (auth()->user()->pets()->save($pet))
                return response()->json([
                    'success' => true,
                    'data' => $pet->toArray()
                ]);
            else
                return response()->json([
                    'success' => false,
                    'message' => 'Pet information could not be added'
                ], 500);
        }
        
        $pet = new Pet();
        $pet->name = $request->name;
        $pet->breed_id = $request->breed_id;
        $pet->date_born = $request->date_born;
        $pet->color = $request->color;
        $pet->category_id = $request->category_id;
        $pet->gender = $request->gender;

        
        if (auth()->user()->pets()->save($pet))
            return response()->json([
                'success' => true,
                'data' => $pet->toArray()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Pet information could not be added'
            ], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pet = auth()->user()->pets()->find($id);
    
        if (!$pet) {
            return response()->json([
                'success' => false,
                'message' => 'Pet with id ' . $id . ' not found'
            ], 400);
        }

        if($request->hasFile('image')) {
            
            $file = $request->file('image');

            if(!$file->isValid()) {
                return response()->json(['invalid_file_upload'], 400);
            }

            // Local
            $file_name = 'pet-' . $request->breed . time() .'.'. $file->getClientOriginalExtension();
            $path = public_path() . '/uploads/pets/';
            $file->move($path, $file_name);

            $pet->name = $request->name ? $request->name : $pet->name;
            $pet->date_born = $request->date_born ? $request->date_born : $pet->date_born;
            $pet->gender = $request->gender ? $request->gender : $pet->gender;
            $pet->color = $request->color ? $request->color : $pet->color;
            $pet->breed_id = $request->breed_id ? $request->breed_id : $pet->breed_id;
            $pet->category_id = $request->category_id ? $request->category_id : $pet->category_id;
            $pet->photo_url = $file_name ? $file_name : $pet->photo_url;      

            $updated = $pet->save();

            if ($updated)
                return response()->json(auth()->user()->pets(), 200);
            else
                return response()->json([
                    'success' => false,
                    'message' => 'Pet could not be updated'
                ], 500);
        }

        $updated = $pet->fill($request->all())->save();
 
        if ($updated)
            return response()->json([
                'success' => true
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Pet could not be updated'
            ], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pet = auth()->user()->pets()->find($id);
 
        if (!$pet) {
            return response()->json([
                'success' => false,
                'message' => 'Pet with id ' . $id . ' not found'
            ], 400);
        }
 
        if ($pet->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Pet could not be deleted'
            ], 500);
        }
    }
}
