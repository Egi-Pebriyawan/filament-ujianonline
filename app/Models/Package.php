<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    protected $fillable = [
        'name',
        'duration',
    ];
//relasi antara file package dan package question namanya questions
    public function questions(): HasMany
    {
        return $this->hasMany(PackageQuestion::class,'package_id');
    }
}
