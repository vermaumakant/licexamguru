<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    public function queryBuilder($query)
    {
        $query->leftJoin('fields', 'courses.field_id', 'fields.id')
            ->select(
                'courses.*',
                'fields.field_name'
            );
        return $query;
    }
    public function scopeGetCourse($query, $filters = [])
    {
        $query = $this->queryBuilder($query);
        if (data_get($filters, 'id')) {
            $query->where('courses.id', $filters['id']);
        }

        if (data_get($filters, 'field_id')) {
            $query->where('courses.field_id', $filters['field_id']);
        }
        return $query;
    }

    public function scopeGetMyCourse($query, $teacher_id) {
        $query->leftJoin('subjects', 'courses.id', 'subjects.course_id');
        $query->where('subjects.teacher_id', $teacher_id);
        $query->groupBy('courses.id');
        return $query;
    }
}
