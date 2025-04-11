<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->enum('species',['dog','cat','other']);
            $table->string('breed');
            $table->string('age');
            $table->string('size');
            $table->string('location');
            $table->string('temperament')->nullable(); // e.g., 'friendly', 'shy', 'energetic'
            $table->text('medical_history')->nullable(); // Detailed medical history as text
            $table->enum('status',['available','adopted'])->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pets');
    }
}
