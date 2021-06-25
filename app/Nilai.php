<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
	protected $table = 'nilai';
	protected $primarykey ='id';
	protected $fillable = ['siswa_id', 'kelas_id', 'guru_id', 'mapel_id', 'tahun_semester', 'ulha', 'uts', 'pat', 'ketrampilan', 'acc'];


  	public function siswa()
  	{
		return $this->belongsTo('App\Siswa')->withDefault();
  	}

  	public function kelas()
  	{
		return $this->belongsTo('App\Kelas')->withDefault();
  	}

  	public function guru()
  	{
		return $this->belongsTo('App\Guru')->withDefault();
  	}

  	public function mapel()
  	{
		return $this->belongsTo('App\Mapel')->withDefault();
  	}
}
