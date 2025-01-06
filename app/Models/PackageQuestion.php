<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// Menghubungkan relasi antar table milik table Package Question
class PackageQuestion extends Model
{
    //data table yang fillable atau boleh di isi
    protected $fillable = [
        'question_id',
        'package_id', 
    ];
// Relasi antara table Package Question ada 2. namanya function package nyambung atau belongs
// to table Package
// Relasi satunya lagi function question belongsto table Question
    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
    public function users()
{
    return $this->belongsToMany(User::class); 
}
}
