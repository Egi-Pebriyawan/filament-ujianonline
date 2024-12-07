<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function package()
    {
        return $this->belongsTo((Package::class));
    }
    public function tryOutAnswers()
    {
        return $this->hasMany(TryoutAnswer::class);
    }
}
