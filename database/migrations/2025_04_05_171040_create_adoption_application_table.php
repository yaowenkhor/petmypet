<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdoptionApplicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adoption_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId("adopter_id")->constrained()->onDelete('cascade');
            $table->foreignId("pet_id")->constrained()->onDelete('cascade');
            $table->foreignId("organization_id")->constrained()->onDelete('cascade');
            $table->text("question")->nullable();
            $table->text("decision_message")->nullable();
            $table->enum("status", ['pending', 'approved', 'rejected'])->default('pending');
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
        Schema::dropIfExists('adoption_applications');
    }
}
