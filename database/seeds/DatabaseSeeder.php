<?php

use App\Tagihan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(HariTableSeeder::class);
        $this->call(JurusansTableSeeder::class);
        $this->call(MapelSeeder::class);
        //$this->call(TagihanSeeder::class);

        Tagihan::create([
            'nama' => 'SPP Semester Ganjil 2022/2023',
            'jumlah' => '100000',
            'keterangan' => 'Wajib',
        ]);
    }
}
