<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gender;

class TableGender extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Gender::insert([
            ['name' => 'Perempuan'],
            ['name' => 'Laki-laki'],
            ['name' => 'Lainnya'],
        ]);
    }
}
