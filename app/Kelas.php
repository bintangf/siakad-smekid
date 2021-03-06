<?php

namespace App;

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
		return $this->belongsTo('App\Jurusan');
	}
	public function guru()
	{
		return $this->belongsTo('App\Guru')->withTrashed();
	}

	public function siswa()
	{
		return $this->hasMany('App\Siswa', 'kelas_id')->withTrashed();
	}
}
