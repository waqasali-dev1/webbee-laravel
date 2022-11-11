<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCinemaSchema extends Migration
{
    /** ToDo: Create a migration that creates all tables for the following user stories

    For an example on how a UI for an api using this might look like, please try to book a show at https://in.bookmyshow.com/.
    To not introduce additional complexity, please consider only one cinema.

    Please list the tables that you would create including keys, foreign keys and attributes that are required by the user stories.

    ## User Stories

     **Movie exploration**
     * As a user I want to see which films can be watched and at what times
     * As a user I want to only see the shows which are not booked out

     **Show administration**
     * As a cinema owner I want to run different films at different times
     * As a cinema owner I want to run multiple films at the same time in different showrooms

     **Pricing**
     * As a cinema owner I want to get paid differently per show
     * As a cinema owner I want to give different seat types a percentage premium, for example 50 % more for vip seat

     **Seating**
     * As a user I want to book a seat
     * As a user I want to book a vip seat/couple seat/super vip/whatever
     * As a user I want to see which seats are still available
     * As a user I want to know where I'm sitting on my ticket
     * As a cinema owner I dont want to configure the seating for every show
     */
    public function up()
    {
        Schema::create('cinemas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('total_seats');
            $table->timestamps();
        });

        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('poster');
            $table->text('details');
            $table->timestamps();
        });

        Schema::create('shows', function (Blueprint $table) {
            $table->id();
            $table->integer('price');
            $table->timestamp('start_at');
            $table->timestamp('end_at');
            $table->tinyInteger('is_active')->default(1);
            $table->string('language');
            $table->enum('print', ['4d', '3d', '2d'])->default('2d');
            $table->foreignId('film_id');
            $table->foreignId('cinema_id');
        });

        Schema::create('seats_per_film', function (Blueprint $table) {
            $table->id();
            $table->integer('sort');
            $table->string('seat_no');
            $table->foreignId('show_id');
            $table->foreignId('user_id')->nullable();
            $table->timestamp('booked_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cinemas');
        Schema::dropIfExists('films');
        Schema::dropIfExists('shows');
        Schema::dropIfExists('seats_per_film');
    }
}
