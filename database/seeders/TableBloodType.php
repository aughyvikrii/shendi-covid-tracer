<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BloodType;

class TableBloodType extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BloodType::insert([
            [ 'name' => 'A' ],
            [ 'name' => 'B' ],
            [ 'name' => 'AB' ],
            [ 'name' => 'O' ],
            [ 'name' => 'Lainnya' ],
        ]);
    }
}
