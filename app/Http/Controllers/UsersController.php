<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function login(Request $request)
    {
        $rules = [
            'email'=>'required|email',
            'password'=>'required'
        ];

        $validation = Validator::make($request->all(),$rules);

        if($validation->fails()){
            return response()->json($validation->errors(), 203);
        }else{
            $password = $request->password;
            $email = $request->email;

            $user = User::where('email', '=', $email)
            ->first();

           


            if($user && Hash::check($password, $user->password)){

               
                $token =$user->createToken('Personal Access Token')->plainTextToken;
                
                return ['user'=>$user, 'token'=>$token];
            }else{
                $message = ['Message'=>"Les informations sont incorrectes"];
                return response()->json($message,203);
            }

        }
        
    }
    public function signup(Request $request)
    {
        
        $name = $request->name;
        $password = Hash::make($request->password);
        $email = $request->email;
        
        $user = User::create([
            'name' => $name,
            'password' => $password,
            'email' => $email
        ]);
        
        $success['token'] = $user->createToken('Personal Access Token')->plainTextToken;
        $success['name'] = $user->name;
        $success['email'] = $user->email;
        
        $message = ["L'utilisateur a été enregistré avec succès 😊"];
        
        return response()->json(['user' => $success, 'message' => $message]);
       

    }
}
