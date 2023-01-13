<?php

use App\Models\Jurusan;
use Illuminate\Database\Seeder;

class JurusansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Jurusan::create([
            'nama' => 'Teknik Komputer dan Informatika',
        ]);
        Jurusan::create([
            'nama' => 'Bisnis daring dan Pemasaran serta Otomatisasi',
        ]);
        Jurusan::create([
            'nama' => 'Tata Kelola Perkantoran',
        ]);
    }
}
