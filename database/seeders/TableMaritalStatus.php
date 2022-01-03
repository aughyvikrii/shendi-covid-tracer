<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\MaritalStatus;

class TableMaritalStatus extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MaritalStatus::insert([
            ['name' => 'Single'],
            ['name' => 'Janda'],
            ['name' => 'Duda'],
            ['name' => 'Lainnya'],
        ]);
    }
}
