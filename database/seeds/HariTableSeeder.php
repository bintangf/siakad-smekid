<?php

use App\Hari;
use Illuminate\Database\Seeder;

class HariTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		Hari::create([
            'id' => 1,
            'nama_hari' => 'Senin',
        ]);
		Hari::create([
            'id' => 2,
            'nama_hari' => 'Selasa',
        ]);
		Hari::create([
            'id' => 3,
            'nama_hari' => 'Rabu',
        ]);
		Hari::create([
            'id' => 4,
            'nama_hari' => 'Kamis',
        ]);
		Hari::create([
            'id' => 5,
            'nama_hari' => "Jum'at",
        ]);
		Hari::create([
            'id' => 6,
            'nama_hari' => "Sabtu",
        ]);
    }
}
