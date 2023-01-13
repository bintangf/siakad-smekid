<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jadwal extends Model
{
    use SoftDeletes;

    protected $table = 'jadwal';

    protected $primarykey = 'id';

    protected $fillable = ['hari_id', 'kelas_id', 'mapel_id', 'guru_id', 'jam_mulai', 'jam_selesai', 'ruang_id'];

    public function hari()
    {
        return $this->belongsTo(\App\Models\Hari::class);
    }

    public function kelas()
    {
        return $this->belongsTo(\App\Models\Kelas::class)->withTrashed();
    }

    public function mapel()
    {
        return $this->belongsTo(\App\Models\Mapel::class)->withTrashed();
    }

    public function guru()
    {
        return $this->belongsTo(\App\Models\Guru::class)->withTrashed();
    }
}
