<?php

use App\Models\Mapel;
use Illuminate\Database\Seeder;

class MapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Mapel::create([
            'nama_mapel' => 'Pendidikan Agama dan Budi Pekerti',
            'jurusan_id' => '4',
            'kelompok' => 'A',
        ]);
        Mapel::create([
            'nama_mapel' => 'Pendidikan Kewarganegaraan',
            'jurusan_id' => '4',
            'kelompok' => 'A',
        ]);
        Mapel::create([
            'nama_mapel' => 'Bahasa Indonesia',
            'jurusan_id' => '4',
            'kelompok' => 'A',
        ]);
        Mapel::create([
            'nama_mapel' => 'Matematika',
            'jurusan_id' => '4',
            'kelompok' => 'A',
        ]);
        Mapel::create([
            'nama_mapel' => 'Bahasa Inggris',
            'jurusan_id' => '4',
            'kelompok' => 'A',
        ]);
        Mapel::create([
            'nama_mapel' => 'Pendidikan Jasmani, Olahraga dan Kesehatan',
            'jurusan_id' => '4',
            'kelompok' => 'B',
        ]);
        Mapel::create([
            'nama_mapel' => 'Otomatisasi Dan Tata Kelola Kepegawaian',
            'jurusan_id' => '3',
            'kelompok' => 'C',
        ]);
        Mapel::create([
            'nama_mapel' => 'Otomatisasi Dan Tata Kelola Keuangan',
            'jurusan_id' => '3',
            'kelompok' => 'C',
        ]);

        Mapel::create([
            'nama_mapel' => 'Otomatisasi dan Tata Kelola Sarana Prasarana',
            'jurusan_id' => '3',
            'kelompok' => 'C',
        ]);

        Mapel::create([
            'nama_mapel' => 'Otomatisasi dan Tata Kelola Humas dan Keproktokolan',
            'jurusan_id' => '3',
            'kelompok' => 'C',
        ]);

        Mapel::create([
            'nama_mapel' => 'Produk Kreatif dan Kewirausahaan',
            'jurusan_id' => '3',
            'kelompok' => 'C',
        ]);
    }
}
