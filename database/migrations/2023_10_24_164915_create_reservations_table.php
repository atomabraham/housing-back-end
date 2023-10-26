<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->integer("id_property");
            $table->integer("id_reserveur");
            $table->integer("id_proprio");
            $table->string("name");
            $table->string("secondname");
            $table->string("email_reserveur");
            $table->string("phone_reserveur");
            $table->longtext("commentaire");
            $table->date("rendezvous");
            $table->string("validate") -> default("false");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
