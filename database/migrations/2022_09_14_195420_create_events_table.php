<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained();
            $table->string("title");
            $table->text("description")->nullable();
            $table->smallInteger("number_of_participants");
            $table->smallInteger("slots_left");
            $table->dateTime("date");
            $table->enum("location", ["akka", "bahji", "haifa"]);
            $table->string("location_detail");
            $table->json("requirements")->nullable();
            $table->enum("payer", ["host", "participants", "all"]);

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
        Schema::dropIfExists('events');
    }
}
