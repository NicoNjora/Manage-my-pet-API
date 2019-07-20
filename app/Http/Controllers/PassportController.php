<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
 
class PassportController extends Controller
{
    /**
     * Handles Registration Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
 
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
 
        $token = $user->createToken('TutsForWeb')->accessToken;
 
        return response()->json(['token' => $token], 200);
    }
 
    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
 
        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('TutsForWeb')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
 
    /**
     * Return Authenticated User Details
     *
     * @return \Illuminate\Http\JsonResponse
    */
    public function details()
    {
        return response()->json(auth()->user(), 200);
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
        if($request->hasFile('image')) {
            
            $file = $request->file('image');

            if(!$file->isValid()) {
                return response()->json(['invalid_file_upload'], 400);
            }

            // Local
            $file_name = 'user-' . auth()->user()->id .'.'. $file->getClientOriginalExtension();
            $path = public_path() . '/uploads/users/';
            $file->move($path, $file_name);

            auth()->user()->name = $request->name ? $request->name : auth()->user()->name;
            auth()->user()->profile_img = $file_name ? $file_name : auth()->user()->profile_img;      
            auth()->user()->email = $request->email ? $request->email : auth()->user()->email;      
            auth()->user()->password = $request->password ? $request->password : auth()->user()->password;

            auth()->user()->save();

            return response()->json(auth()->user(), 200);
        }


        $updated = auth()->user()->fill($request->all())->save();
 
        if ($updated)
            return response()->json(auth()->user(), 200);
        else
            return response()->json([
                'success' => false,
                'message' => 'User could not be updated'
            ], 500);
    }
}
