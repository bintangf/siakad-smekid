<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siswa extends Model
{
    use SoftDeletes;

    protected $table = 'siswa';

    protected $primarykey = 'id';

    protected $fillable = ['user_id', 'kelas_id', 'no_induk', 'nis', 'nama_siswa', 'jk', 'telp', 'tmp_lahir', 'tgl_lahir'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function kelas()
    {
        return $this->belongsTo('App\Kelas')->withTrashed();
    }

    public function detailTagihan()
    {
        return $this->hasMany('App\detailTagihan', 'siswa_id');
    }

    public function nilai($id)
    {
        $nilai = Nilai::where('siswa_id', $id[0])
                    ->where('kelas_id', $id[1])
                    ->where('guru_id', $id[2])
                    ->where('mapel_id', $id[3])
                    ->where('tahun_semester', $id[4])
                    ->first();

        return $nilai;
    }
}
