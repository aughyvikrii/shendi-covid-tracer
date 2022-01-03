<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();

            $table->string('kk')->length(255);
            $table->string('nik')->length(255);

            $table->string('name', 100);
            $table->string('first_name', 100);
            $table->string('last_name', 100);

            $table->date('date_of_birth');
            $table->text('place_of_birth');
            $table->string('photo')->nullable();

            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();

            $table->boolean('on_covid')->default(false);

            $table->text('address');

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
        Schema::dropIfExists('people');
    }
}
