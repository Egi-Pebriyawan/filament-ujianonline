<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TryoutAnswer extends Model
{
    // // membuat agar row bisa di isi 
    protected $fillable = [
        'tryout_id',
       'question_id',
        'option_id',
        'score',
    ];
    
}
