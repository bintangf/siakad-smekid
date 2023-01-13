<?php

namespace App\Imports;

use App\Models\Guru;
use App\Models\Mapel;
use Maatwebsite\Excel\Concerns\ToModel;

class GuruImport implements ToModel
{
    /**
     * @param  array  $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $mapel = Mapel::where('nama_mapel', $row[3])->first();
        $guru = Guru::create([
            'nip' => $row[0],
            'nama_guru' => $row[1],
            'jk' => $row[2],
        ]);

        return $guru->mapel()->attach($mapel->id);
    }
}
