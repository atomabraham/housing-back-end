<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OptionPropertyController;
use App\Http\Controllers\UsersController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*Route d'authentification*/

//route de l'inscription
Route::post('/register',[AuthController::class,'register']);

//route de la connexion
Route::post('/login',[AuthController::class,'login']);

//route d'affichage de la liste de tous les utilisateurs de la plateformes
Route::get('/users',[UsersController::class,'index']);

//route qui verifie si une adresse email est deja prise
Route::post('/emailVerification',[UsersController::class,'UserExist']);

//routes de deconnexion et d'affichage des information de l'utilisateur
Route::middleware('auth:sanctum')->group(function(){
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'userss']);
});

/*routes de gestion des propriétés*/

//gestion des options de propriété
Route::post('/createOption',[OptionPropertyController::class,'store']);
Route::get('/options',[OptionPropertyController::class,'index']);
Route::get('/option',[OptionPropertyController::class,'show']);
Route::delete('/deleteOption/{id}',[OptionPropertyController::class,'destroy']);

//gestion des propriétés
