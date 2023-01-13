<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guru extends Model
{
    use SoftDeletes;

    protected $table = 'guru';

    protected $primarykey = 'id';

    protected $fillable = ['user_id', 'nip', 'nama_guru', 'jk', 'telp', 'tmp_lahir', 'tgl_lahir'];

    public function kelas()
    {
        return $this->hasOne(\App\Models\Kelas::class)->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function mapel()
    {
        return $this->belongsToMany(\App\Models\Mapel::class)->withTrashed();
    }
}
