<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePeopleDropColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('people', function (Blueprint $table) {
            $table->dropColumn([
                'infected_date_start', 'infected_date_end',
                'covid_infected_start', 'covid_infected_end'
            ]);
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
}
