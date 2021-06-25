<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quiz extends Model
{
    use HasFactory, SoftDeletes;
    public function queryBuilder($query){
        $query->leftJoin('fields', 'quizzes.field_id', 'fields.id')
            ->leftJoin('courses', 'quizzes.course_id', 'courses.id')
            ->leftJoin('subjects', 'quizzes.subject_id', 'subjects.id')
            ->leftJoin('lessons', 'quizzes.lesson_id', 'lessons.id')
            ->leftJoin('quiz_questions', 'quizzes.id', 'quiz_questions.quiz_id');
        $query->select(
            'quizzes.*',
            'fields.field_name',
            'courses.course_name',
            'subjects.subject_name',
            'lessons.lesson_name',
            DB::raw("COUNT(quiz_questions.id) as questions")
        );
        $query->groupBy('quizzes.id');
        return $query;
    }
    public function scopeGetQuizes($query, $course_id, $subject_id, $lesson_id) {
        $query = $this->queryBuilder($query);
        $query->where('quizzes.course_id', $course_id);
        $query->where('quizzes.subject_id', $subject_id);
        $query->where('quizzes.lesson_id', $lesson_id);
        return $query;
    }

    public function scopeFindQuiz($query, $quiz_id) {
        $query = $this->queryBuilder($query);
        $query->where('quizzes.id', $quiz_id);
        return $query;
    }
}
