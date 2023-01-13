<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelas extends Model
{
    use SoftDeletes;

    protected $table = 'kelas';

    protected $primarykey = 'id';

    protected $fillable = ['nama_kelas', 'jurusan_id', 'guru_id'];

    public function jurusan()
    {
        return $this->belongsTo(\App\Models\Jurusan::class);
    }

    public function guru()
    {
        return $this->belongsTo(\App\Models\Guru::class)->withTrashed();
    }

    public function siswa()
    {
        return $this->hasMany(\App\Models\Siswa::class, 'kelas_id')->withTrashed();
    }
}
