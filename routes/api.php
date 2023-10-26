<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OptionPropertyController;
use App\Http\Controllers\PropertiesController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SearchController;
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

//Routes modification du profile
Route::post('/updateProfilePicture/{user}',[UsersController::class,'ProfilePicture']);
Route::post('/updateInformationUser/{user}',[UsersController::class,'UpdateInformationUser']);

//routes de deconnexion et d'affichage des information de l'utilisateur
Route::middleware('auth:sanctum')->group(function(){
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'users']);
});


//Routes de gestion des options de propriété
Route::post('/createOption',[OptionPropertyController::class,'store']);
Route::get('/options',[OptionPropertyController::class,'index']);
Route::get('/option',[OptionPropertyController::class,'show']);
Route::delete('/deleteOption/{id}',[OptionPropertyController::class,'destroy']);

/*routes de gestion des propriétés*/
Route::get('/properties', [PropertiesController::class,'index']);
Route::post('/createProperties', [PropertiesController::class,'store']);
Route::get('/property/{id}',[PropertiesController::class,'show']);
Route::put('/propertyEdit/{id}',[PropertiesController::class,'update']);
Route::delete('/property/{id}',[PropertiesController::class,'destroy']);
Route::post('/viewProperties/{property}',[PropertiesController::class,'viewProperties']);
Route::get('propertyUsers/{id}',[PropertiesController::class,'PropertiesUser']);
Route::get('/propertiesToActive',[PropertiesController::class,'propertiesToActive']);
Route::get('/propertiesReserved',[PropertiesController::class,'propertiesReserved']);
Route::get('/propertiesVendu',[PropertiesController::class,'propertiesVendu']);
Route::post('/validateProperty/{property}',[PropertiesController::class,'validateProperty']);

//route de filtre
Route::post('/search',[SearchController::class,'search']);

//route de gestion des reservation
Route::post('/reservation',[ReservationController::class,'store']);
Route::post('/updatePropertyReserved/{property}',[ReservationController::class,'updateproperty']);

