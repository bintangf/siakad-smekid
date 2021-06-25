<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guru extends Model
{
    use SoftDeletes;

    protected $table = 'Guru';
    protected $primarykey ='id';
    protected $fillable = ['user_id', 'nip', 'nama_guru', 'jk', 'telp', 'tmp_lahir', 'tgl_lahir'];

	public function kelas() { 
	    return $this->hasOne('App\Kelas'); 
	}
    public function user()
    {
        return $this->belongsTo('App\User');
    }
	public function mapel() { 
	    return $this->belongsToMany('App\Mapel'); 
	}
}
