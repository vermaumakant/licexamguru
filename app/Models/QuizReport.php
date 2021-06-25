<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuizReport extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'quiz_id', 'user_id', 'created_at', 'updated_at',
    ];

    protected $casts = [
        'details' => 'array',
    ];
    public function scopeUpdateCurrentQuestion($query, $quiz_id, $question_id, $user_id) {
        $query->where('user_id', $user_id);
        $query->where('quiz_id', $quiz_id);
        $query->update(['current_question_id' => $question_id]);
    }
}
