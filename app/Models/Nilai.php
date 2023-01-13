<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $table = 'nilai';

    protected $primarykey = 'id';

    protected $fillable = ['siswa_id', 'kelas_id', 'guru_id', 'mapel_id', 'tahun_semester', 'ulha', 'uts', 'pat', 'ketrampilan', 'acc'];

    public function siswa()
    {
        return $this->belongsTo(\App\Models\Siswa::class)->withTrashed();
    }

    public function kelas()
    {
        return $this->belongsTo(\App\Models\Kelas::class)->withTrashed();
    }

    public function guru()
    {
        return $this->belongsTo(\App\Models\Guru::class)->withTrashed();
    }

    public function mapel()
    {
        return $this->belongsTo(\App\Models\Mapel::class)->withTrashed();
    }
}
