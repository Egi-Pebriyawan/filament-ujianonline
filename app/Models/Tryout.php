<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tryout extends Model
{
    // membuat agar row bisa di isi 
    protected $fillable = [
        'user_id',
        'package_id',
        'duration',
        'started_at',
        'finished_at',

    ];
}
