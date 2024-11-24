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

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
