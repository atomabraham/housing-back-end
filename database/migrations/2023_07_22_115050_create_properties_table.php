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
            $table->id();
            $table->string('propertyName');
            $table->string('propertyType');
            $table->string('propertyStatus');
            $table->integer('bedrooms');
            $table->integer('bathrooms');
            $table->integer('area');
            $table->integer('price') ;
            $table->string('country') ;
            $table->string('city') ;
            $table->string('quartier') -> nullable();
            $table->string('postalcode') -> nullable();
            $table->longText('description');
            $table->string('image');
            $table->string('contactName');
            $table->string('contactEmail');
            $table->string('contactPhone');
            $table->string('contactEnable') -> default('true');
            $table->timestamps();
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
