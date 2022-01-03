<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Religion;

class TableReligion extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Religion::insert([
            [ 'name' => 'Islam' ],
            [ 'name' => 'Kristen' ],
            [ 'name' => 'Katholik' ],
            [ 'name' => 'Hindu' ],
            [ 'name' => 'Budha' ],
            [ 'name' => 'Konghucu' ],
            [ 'name' => 'Lainnya' ],
        ]);
    }
}
