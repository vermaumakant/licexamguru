<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lesson extends Model
{
    use HasFactory;

    public function queryBuilder($query)
    {
        $query->leftJoin('admins', 'lessons.teacher_id', 'admins.id')
            ->leftJoin('fields', 'lessons.field_id', 'fields.id')
            ->leftJoin('courses', 'lessons.course_id', 'courses.id')
            ->leftJoin('subjects', 'lessons.subject_id', 'subjects.id')
            ->LeftJoin('videos', 'lessons.id', 'videos.lesson_id');
        $query->select(
            'lessons.*',
            'admins.name as teacher_name',
            'fields.field_name',
            'courses.course_name',
            'subjects.subject_name',
            DB::raw("COUNT(videos.id) as videos")
        );
        $query->groupBy('lessons.id');
        return $query;
    }

    public function scopeGetLessions($query, $course_id, $subject_id)
    {
        $query = $this->queryBuilder($query);
        $query->where('lessons.course_id', $course_id);
        $query->where('lessons.subject_id', $subject_id);
        return $query;
    }

    public function scopeFindLesson($query, $lesson_id) {
        $query = $this->queryBuilder($query);
        $query->where('lessons.id', $lesson_id);
        return $query->first();
    }
}
