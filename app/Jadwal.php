<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jadwal extends Model
{
  use SoftDeletes;

  protected $table = 'Jadwal';
  protected $primarykey ='id';
  protected $fillable = ['hari_id', 'kelas_id', 'mapel_id', 'guru_id', 'jam_mulai', 'jam_selesai', 'ruang_id'];

  public function hari()
  {
    return $this->belongsTo('App\Hari')->withDefault();
  }

  public function kelas()
  {
    return $this->belongsTo('App\Kelas')->withDefault();
  }

  public function mapel()
  {
    return $this->belongsTo('App\Mapel')->withDefault();
  }

  public function guru()
  {
    return $this->belongsTo('App\Guru')->withDefault();
  }
}
