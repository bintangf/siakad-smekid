<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayarans';
    protected $primarykey ='id';
    protected $fillable = ['detail_tagihan_id', 'jumlah', 'keterangan'];
    
    public function detailTagihan()
    {
      return $this->belongsTo('App\detailTagihan');
    }
}
