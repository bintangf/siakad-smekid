<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hari extends Model
{
    protected $table = 'hari';

    protected $primarykey = 'id';

    protected $fillable = ['nama_hari'];
}
