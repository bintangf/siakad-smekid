<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    protected $table = 'jurusan';

    protected $primarykey = 'id';

    protected $fillable = ['nama'];

    public function mapels()
    {
        return $this->hasMany(\App\Models\Mapel::class)->withTrashed();
    }

    public function kelas()
    {
        return $this->hasMany(\App\Models\Kelas::class)->withTrashed();
    }
}
