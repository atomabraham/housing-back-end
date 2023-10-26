<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MailController extends Controller
{
    //
    public function store()
    {
        $reservation = Reservation::create([
            'user_id' => auth()->user()->id,
            'property_id' => request('property_id'),
            'start_date' => request('start_date'),
            'end_date'p => request('end_date'),
        ]);

        // Envoie un mail à l'utilisateur
        Mail::send('emails.reservation', [
            'reservation' => $reservation,
        ], function ($mail) {
            $mail->to(auth()->user()->email);
            $mail->subject('Votre réservation a bien été envoyée');
        });

        return redirect()->route('properties.index');
    }
}
