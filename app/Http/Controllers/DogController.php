<?php

namespace App\Http\Controllers;

use App\Dog;
use Illuminate\Http\Request;

class DogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dogs = auth()->user()->dogs;
 
        return response()->json($dogs);
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
            'breed' => 'required',
            'age' => 'required|integer',
            'photo_url' => 'required'
        ]);
 
        $dog = new Dog();
        $dog->name = $request->name;
        $dog->breed = $request->breed;
        $dog->age = $request->age;
        $dog->photo_url = $request->photo_url;
 
        if (auth()->user()->dogs()->save($dog))
            return response()->json([
                'success' => true,
                'data' => $dog->toArray()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Dog information could not be added'
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
        $dog = auth()->user()->dogs()->find($id);
 
        if (!$dog) {
            return response()->json([
                'success' => false,
                'message' => 'Dog with id ' . $id . ' not found'
            ], 400);
        }
 
        $updated = $dog->fill($request->all())->save();
 
        if ($updated)
            return response()->json([
                'success' => true
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Dog could not be updated'
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
        $dog = auth()->user()->dogs()->find($id);
 
        if (!$dog) {
            return response()->json([
                'success' => false,
                'message' => 'Dog with id ' . $id . ' not found'
            ], 400);
        }
 
        if ($dog->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Dog could not be deleted'
            ], 500);
        }
    }
}
