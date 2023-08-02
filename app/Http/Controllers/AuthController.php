<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
class AuthController extends Controller
{
    //
    public function register(Request $request)
    {  
        try {
            //code...
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
                'npwp' => 'required',
                'nik'=> 'required'
            ]);
            //    dd($request->all());
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'npwp' => $request->npwp,
                'nik' => $request->nik
            ];
            $check = User::create($data);
            return response()->json($check);
        } catch (Exception $e) {
            return response()->json($e->getMessage());
            
        }
         
    }
}
