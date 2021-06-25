<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hari extends Model
{
    protected $table = 'Hari';
    protected $primarykey ='id';
    protected $fillable = ['nama_hari'];
}
