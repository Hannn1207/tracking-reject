<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    protected $table = 'targets';
    protected $fillable = [
        'jam_awal',
        'jam_akhir',
        'jenis',
        'qty',
    ];
}
