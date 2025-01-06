<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Package extends Model
{
    protected $fillable = [
        'name',
        'duration',
        'start_datetime', 
        'end_datetime'
    ];
//relasi antara file package dan package question namanya questions ( namanya gk harus questions bebas aja)
//dimana function questions memiliki relasi has many atau banyak relasi ke table
// package question dan relasinya nyangkut menggunakna foregn id package_id
    public function questions(): HasMany
    {
        return $this->hasMany(PackageQuestion::class,'package_id');
    }
    public function users()
{
    return $this->belongsToMany(User::class, 'package_user', 'package_id', 'user_id');
}

 // Relasi one-to-many dengan User (jika kolom user_id ditambahkan di tabel packages)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class); // Relasi satu ke banyak
    }

}
