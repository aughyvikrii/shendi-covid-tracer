<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('patient_id')
                ->references('id')->on('people');

            $table->string('infection_status', 25)
                ->default('infected')
                ->comment('healed,die');

            $table->date('infected_date_start')
                ->nullable();

            $table->date('infected_date_end')
                ->nullable();

            $table->string('covid_infected_start')
                ->nullable();

            $table->string('covid_infected_end')
                ->nullable();

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
        Schema::dropIfExists('registrations');
    }
}
