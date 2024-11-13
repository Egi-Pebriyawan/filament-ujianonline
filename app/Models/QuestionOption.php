<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuestionOption extends Model
{
//agar question bisa masuk ke database tambahkan kode protected fillable 
protected $fillable = [ 'question_id', 'option_text', 'score'];



    //Fungsi untuk menghubungkan table option question ke question 
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
