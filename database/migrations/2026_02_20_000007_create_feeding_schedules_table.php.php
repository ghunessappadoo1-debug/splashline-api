<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedingSchedulesTable extends Migration
{
    public function up()
    {
        Schema::create('feeding_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exhibit_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('animal_id')->nullable()->constrained()->onDelete('cascade');
            $table->time('feeding_time');
            $table->string('food_type')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('feeding_schedules');
    }
}