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
        Schema::create('properties', function (Blueprint $table) {
            $table -> id();
            $table -> string('propertyName') ->nullable();
            $table -> string('propertyType') ->nullable();
            $table -> string('propertyStatus') ->nullable();
            $table -> integer('bedrooms') ->nullable();
            $table -> integer('bathrooms') ->nullable();
            $table -> integer('area') ->nullable();
            $table -> integer('price') ->nullable() ;
            $table -> string('country') ->nullable() ;
            $table -> string('city') ->nullable() ;
            $table -> string('quartier') -> nullable();
            $table -> string('postalcode') -> nullable();
            $table -> longText('description') ->nullable();
            $table -> json('agrement') -> nullable();
            $table -> json('images');
            $table -> string('contactName') ->nullable();
            $table -> string('contactEmail') ->nullable();
            $table -> string('contactPhone') ->nullable();
            $table -> string('contactEnable') -> default('true');
            $table -> timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
