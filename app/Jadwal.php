<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jadwal extends Model
{
  use SoftDeletes;

  protected $table = 'jadwal';
  protected $primarykey ='id';
  protected $fillable = ['hari_id', 'kelas_id', 'mapel_id', 'guru_id', 'jam_mulai', 'jam_selesai', 'ruang_id'];

  public function hari()
  {
    return $this->belongsTo('App\Hari');
  }

  public function kelas()
  {
    return $this->belongsTo('App\Kelas')->withTrashed();
  }

  public function mapel()
  {
    return $this->belongsTo('App\Mapel')->withTrashed();
  }

  public function guru()
  {
    return $this->belongsTo('App\Guru')->withTrashed();
  }
}
