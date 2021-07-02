<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    protected $table = 'jurusan';
    protected $primarykey ='id';
    protected $fillable = ['nama'];

	public function mapels() { 
	    return $this->hasMany('App\Mapel')->withTrashed();
	}
	public function kelas() { 
	    return $this->hasMany('App\Kelas')->withTrashed();
	}

}
