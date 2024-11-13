<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    //Fungsi untuk menghubungkan table question ke question option
    public function options(): HasMany
    {
        return $this->hasMany(QuestionOption::class);
    }
}
