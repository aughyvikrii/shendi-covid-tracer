<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('people', function (Blueprint $table) {
            
            $table->integer('height')->length(255)->nullable();
            $table->integer('weight')->length(255)->nullable();


            $table->foreignId('gender_id')
                ->references('id')->on('genders');

            $table->foreignId('marital_status_id')
                ->references('id')->on('marital_statuses');

            $table->foreignId('religion_id')
                ->references('id')->on('religions');

            $table->foreignId('blood_type_id')
                ->references('id')->on('blood_types');

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
            $table->dropColumn([
                'height', 'weight', 'gender_id', 'marital_status_id', 'religion_id', 'blood_type_id'
            ]);
        });
    }
}
