<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuizQuestion extends Model
{
    use HasFactory, SoftDeletes;

    public function scopeGetQuestion($query, $quiz_id, $skip = 0) {
        $query->where('quiz_id', $quiz_id);
        $query->skip($skip)->take(1);
        return $query->first();
    }
}
