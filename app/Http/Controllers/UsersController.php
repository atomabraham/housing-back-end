<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    //recuperation de tout les utilisateurs de la plateformes

    public function index(){

        $users=User::all();

        return response() -> json($users);
    }

    //verification de l'existence ou non d'une adresse email
    public function UserExist(User $user, Request $request){
        $this->validate($request,[
            'email'=>'required',
        ]);

        $emailToChecked = $request -> email ;
        $user= User :: where('email', $emailToChecked)->get();

        if(count($user)){
            return response() -> json(['message' => 'found']);
        }else{
            return response() -> json(['message' => 'not found']);
        }
    }
}
