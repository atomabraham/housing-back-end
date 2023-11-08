<?php

namespace App\Http\Controllers;

use App\Models\Propertie;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * take a reservation
     */
    public function index()
    {
        //
        $reservation = Reservation::all();

        return response() -> json($reservation,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate ([
            'id_property' => 'required',
            'id_reserveur' => 'required',
            'id_proprio' => 'required',
            'name' => 'required',
            'secondname' => 'required',
            'email_reserveur' => 'required',
            'phone_reserveur' => 'required',
            'rendezvous' => 'required'
        ]);

        $reservation = new Reservation();

        $reservation->id_property = $request -> input('id_property');
        $id_property = $request -> input('id_property');
        $reservation->id_reserveur= $request -> input('id_reserveur');
        $reservation->id_proprio= $request -> input('id_proprio');
        $reservation->name= $request -> input('name');
        $reservation->secondname= $request -> input('secondname');
        $reservation->email_reserveur= $request -> input('email_reserveur');
        $reservation->phone_reserveur= $request -> input('phone_reserveur');
        $reservation->commentaire= $request -> input('commentaire');
        $reservation->rendezvous= $request -> input('rendezvous');
        $reservation->rendezvous= $request -> input('rendezvous');

        $reservation -> save();

        return response() ->json(200);
    }

    // confirmer une reservation
    public function confirmationReservation (Request $request, Reservation $reservation){
        $reservation -> update($request -> except('validate'));

        $reservation -> validate = "true";

        $reservation -> save();
    }

    // confirmer une reservation
    public function updatePropertyReserced (Request $request, Propertie $property){
        $property -> update($request -> except('reserver'));

        $property -> reserver = "true";

        $property -> save();
    }
}
