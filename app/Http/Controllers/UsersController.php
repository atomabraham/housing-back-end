<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    //update profile picture
    public function ProfilePicture (Request $request, User $user){
        try {
            $request->validate([
                'picture'=>'nullable|image'
            ]);

            // $user= User::findOrFail($id);

            $user->update($request->except(['picture']));

            // Mettre à jour l'image de profil
            if ($request->hasFile('picture')){
                // Supprimer l'ancienne image de profil

                if($user -> profil){
                    $exists = Storage::disk('public')->exists("images/profilePicture/{$user->picture}");
                    if ($exists) {
                        Storage::disk('public')->delete("images/profilePicture/{$user->picture}");
                    }
                }

                // Enregistrer la nouvelle image de profil
                $image = $request->file('picture');

                // Générez un nom unique pour l'image en utilisant le timestamp actuel
                $profilImageName = Str::random().'.'.$request->picture->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('images/profilePicture', $request->picture, $profilImageName);

                // Mettre à jour le nom de l'image de profil dans le modèle
                $user->picture=$profilImageName;

                $user->save();

                return response() -> json($user);
            }
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors()
        ], 422);
        }catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json([
                'message' => 'Something went wrong while updating an InfosUser!',
                'errors' => $e->errors(),
                'exception' => $e
            ], 500);
        }
    }
        //update information user
        public function UpdateInformationUser (Request $request, User $user) {
            try {
                $request ->validate([
                    'userName' => 'nullable',
                    'name' => 'required',
                    'secondname' => 'required',
                    'address' => 'nullable',
                    'phone' => 'required',
                    'birthday' => 'required',
                    'country' => 'required',
                    'city' => 'required',
                    'postalCode' => 'nullable',
                ]);

                $user->update($request->except(['userName','name','secondName','address','phone','birthday','country','city','postalCode']));

                $user -> userName = $request -> input('userName');
                $user -> name = $request -> input('name');
                $user -> secondname = $request -> input('secondname');
                $user -> address = $request -> input('address');
                $user -> phone = $request -> input('phone');
                $user -> birthday = $request -> input('birthday');
                $user -> country = $request -> input('country');
                $user -> city = $request -> input('city');
                $user -> postalCode = $request -> input('postalCode');

                $user -> save();

            } catch (ValidationException $e) {
                return response()->json([
                    'message' => 'Validation error',
                    'errors' => $e->errors()
                ], 422);
            }
        }
}

