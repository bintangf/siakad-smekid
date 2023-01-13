<?php

namespace App\Imports;

use App\Kelas;
use App\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;

class SiswaImport implements ToModel
{
    /**
     * @param  array  $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $kelas = Kelas::where('nama_kelas', $row[3])->first();

        return new Siswa([
            'no_induk' => $row[0],
            'nama_siswa' => $row[1],
            'jk' => $row[2],
            'kelas_id' => $kelas->id,
        ]);
    }
}
