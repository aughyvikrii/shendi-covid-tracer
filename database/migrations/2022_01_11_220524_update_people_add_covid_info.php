<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePeopleAddCovidInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('people', function (Blueprint $table) {
            $table->dropColumn('on_covid');

            $table->string('covid_status', 25)
                ->default('never_infected')
                ->comment('never_infected, being_infected, been_infected');

            $table->date('infected_date_start')
                ->nullable();

            $table->date('infected_date_end')
                ->nullable();

            $table->string('covid_infected_start')
                ->nullable();

            $table->string('covid_infected_end')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('people', function (Blueprint $table) {
            $table->boolean('on_covid')->default(false);
            $table->dropColumn([
                'covid_status', 'infected_date_start', 'infected_date_end',
                'covid_infected_start', 'covid_infected_end'
            ]);
        });
    }
}
