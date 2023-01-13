<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detailTagihan extends Model
{
    protected $table = 'detail_tagihans';

    protected $primarykey = 'id';

    protected $fillable = ['siswa_id', 'tagihan_id', 'keterangan'];

    public function siswa()
    {
        return $this->belongsTo(\App\Siswa::class)->withTrashed();
    }

    public function tagihan()
    {
        return $this->belongsTo(\App\Tagihan::class)->withTrashed();
    }

    public function pembayaran()
    {
        return $this->hasMany(\App\Pembayaran::class, 'detail_tagihan_id');
    }
}
