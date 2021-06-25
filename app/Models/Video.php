<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    public function queryBuilder($query) {
        $query->leftJoin('admins', 'videos.teacher_id', 'admins.id')
            ->leftJoin('fields', 'videos.field_id', 'fields.id')
            ->leftJoin('courses', 'videos.course_id', 'courses.id')
            ->leftJoin('subjects', 'videos.subject_id', 'subjects.id')
            ->leftJoin('lessons', 'videos.lesson_id', 'lessons.id');
        
        $query->select(
            'videos.*',
            'admins.name as teacher_name',
            'fields.field_name',
            'courses.course_name',
            'subjects.subject_name',
            'lessons.lesson_name'
        );
        return $query;
    }
    
    public function scopeGetVideo($query, $course_id, $subject_id, $lesson_id) {
        $query = $this->queryBuilder($query);
        $query->where('videos.course_id', $course_id);
        $query->where('videos.subject_id', $subject_id);
        // if($lesson_id) {
            $query->where('videos.lesson_id', $lesson_id);
        // }

        return $query;
    }

    public function scopeGetFreeVideos($query, $course_id, $subject_id) {
        $query = $this->queryBuilder($query);
        $query->where('videos.course_id', $course_id);
        if($subject_id) {
            $query->where('videos.subject_id', $subject_id);
        }
        $query->where('videos.is_free', true);
        return $query;
    }

}
