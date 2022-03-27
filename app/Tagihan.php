<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tagihan extends Model
{
    use SoftDeletes;

    protected $table = 'tagihans';
    protected $primarykey ='id';
    protected $fillable = ['nama', 'jumlah', 'keterangan'];
}
