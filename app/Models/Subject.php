<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    public function queryBuilder($query)
    {
        $query->leftJoin('admins', 'subjects.teacher_id', 'admins.id')
            ->leftJoin('fields', 'subjects.field_id', 'fields.id')
            ->leftJoin('courses', 'subjects.course_id', 'courses.id');

        $query->select(
            'subjects.*',
            'admins.name as teacher_name',
            'fields.field_name',
            'courses.course_name'
        );
        return $query;
    }

    public function scopeGetSubjects($query, $course_id)
    {
        $query = $this->queryBuilder($query);
        if ($course_id) {
            $query->where('course_id', $course_id);
        }
        return $query;
    }

    public function scopeFindSubject($query, $subject_id) {
        $query = $this->queryBuilder($query);
        $query->where('subjects.id', $subject_id);
        return $query->first();
    }
}
