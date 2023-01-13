<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mapel extends Model
{
    use SoftDeletes;

    protected $table = 'mapel';

    protected $primarykey = 'id';

    protected $fillable = ['jurusan_id', 'nama_mapel', 'kelompok'];

    public function jurusan()
    {
        return $this->belongsTo(\App\Jurusan::class);
    }

    public function guru()
    {
        return $this->belongsToMany(\App\Guru::class)->withTrashed();
    }
}
