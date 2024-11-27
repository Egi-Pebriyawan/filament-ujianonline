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
//relasi antara file package dan package question namanya questions ( namanya gk harus questions bebas aja)
//dimana function questions memiliki relasi has many atau banyak relasi ke table
// package question dan relasinya nyangkut menggunakna foregn id package_id
    public function questions(): HasMany
    {
        return $this->hasMany(PackageQuestion::class,'package_id');
    }
}
