<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class VideoOfDay extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'course_id', 'visible_at', 'video_id'
     ];
    public function scopeVideoOfDay($query, $course_id) {
        $query->leftJoin('courses', 'video_of_days.course_id', 'courses.id');
        $query->where('video_of_days.visible_at' , '=', date("Y-m-d"));
        $query->where('video_of_days.course_id', $course_id);
        $video_of_day = $query->first();
        if(!$video_of_day) {
            $video_of_day = $this->createVideoOfDay($course_id);
        }
        if($video_of_day) {
            $video_of_day = Video::leftJoin('subjects', 'videos.subject_id', 'subjects.id')
                ->leftJoin('admins', 'videos.teacher_id', 'admins.id')
                ->where('videos.id', $video_of_day->video_id)
                ->first();
        }
        return $video_of_day;
    }

    public function createVideoOfDay($course_id) {
        $video = Video::leftJoin('video_of_days', 'videos.course_id', 'video_of_days.course_id')
            ->where('videos.is_free', true)
            ->where('videos.course_id', $course_id)
            ->whereNull('video_of_days.id')
            ->select('videos.id')
            ->first();
        $this->delete();
        if($video) {
            $video_of_day = $this->create([
                'course_id' => $course_id,
                'visible_at' => date("Y-m-d"),
                'video_id' => $video->id
            ]);
            return $video_of_day;
        }
        return null;
    }
}
