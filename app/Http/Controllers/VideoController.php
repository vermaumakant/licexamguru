<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Lesson;
use App\Models\Level;
use App\Models\Quiz;
use App\Models\Subject;
use App\Models\UserCourseMapping;
use App\Models\Video;
use App\Models\VideoOfDay;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class VideoController extends Controller
{
    public function index($course_id, $subject_id, $lesson_id = null)
    {
        $query = Video::getVideo($course_id, $subject_id, $lesson_id);
        if (auth()->user()->admin_type == 'teacher') {
            $query->where('videos.teacher_id', auth()->user()->id);
        }
        $videos = $query->get();
        return response()->json(['videos' => $videos]);
    }

    public function freeVideos($course_id=null, $subject_id=null) {
        if(!$course_id) {
            $user = auth()->user();
            $user_course_mapping = UserCourseMapping::where('user_id', $user->id)->first();
            $course_id = $user_course_mapping->course_id;
        }

        $query = Video::getFreeVideos($course_id, $subject_id);
        if (auth()->user()->admin_type == 'teacher') {
            $query->where('videos.teacher_id', auth()->user()->id);
        }
        $videos = $query->get();
        return response()->json(['videos' => $videos]);
    }
    public function find($course_id, $subject_id, $lesson_id, $video_id)
    {
        $video = Video::getVideo($course_id, $subject_id, $lesson_id)
            ->where('videos.id', $video_id)
            ->first();
        return response()->json(['video' => $video]);
    }

    public function saveVideo(Request $request, $course_id, $subject_id, $lesson_id=null)
    {
        $video_data = $request->all();
        $subject = Subject::find($subject_id);
        $data = [
            'field_id' => $subject->field_id,
            'course_id' => $course_id,
            'subject_id' => $subject_id,
            'lesson_id' => $lesson_id,
            'video_title' => data_get($video_data, 'video_title'),
            'video' => data_get($video_data, 'video'),
            'video_type' => data_get($video_data, 'video_type'),
            'description' => data_get($video_data, 'description'),
            'is_free' => data_get($video_data, 'is_free', false)
        ];
        $this->storeVideoData($video_data, $data);
        return response()->json(['message' => 'saved']);
    }

    public function addRevisionVideo(Request $request, $course_id, $subject_id)
    {
        $video_data = $request->all();
        $subject = Subject::find($subject_id);
        $data = [
            'field_id' => $subject->field_id,
            'course_id' => $course_id,
            'subject_id' => $subject_id,
            'video_title' => data_get($video_data, 'video_title'),
            'video' => data_get($video_data, 'video'),
            'description' => data_get($video_data, 'description'),
        ];
        $this->storeVideoData($video_data, $data);
        return response()->json(['message' => 'saved']);
    }

    public function storeVideoData($video_data, $data)
    {
        $video_thumb = data_get($video_data, 'video_thumb', false);
        if ($video_thumb) {
            $origin_path = storage_path('app/' . $video_thumb);
            if (file_exists($origin_path)) {
                $ext = pathinfo(storage_path('app/' . $video_thumb), PATHINFO_EXTENSION);
                $video_thumb = 'video-thumbs/' . str_replace(" ", "_", $data['video_title']) . '-' . auth()->user()->id . time() . "." . $ext;
                $destination_path = public_path($video_thumb);
                File::move($origin_path, $destination_path);
                $data['video_thumb'] = $video_thumb;
            }
        }

        $video = data_get($video_data, 'video', false);
        if ($video) {
            $origin_path = storage_path('app/' . $video);
            if (file_exists($origin_path)) {
                $ext = pathinfo(storage_path('app/' . $video), PATHINFO_EXTENSION);
                $video = 'videos/' . str_replace(" ", "_", $data['video_title']) . '-' . auth()->user()->id . time() . "." . $ext;
                $destination_path = public_path($video);
                File::move($origin_path, $destination_path);
                $data['video'] = $video;
            }
        }
        if($data['video_type'] == 'link') {
            $thumb_path = 'video-thumbs/'.time().'.png';
    
            $cmd = env('FFMPEG_PATH').' -i '. $data['video']. " -frames:v 1 -s 600x320 ".public_path( $thumb_path);
            system($cmd);
            $data['video_thumb'] = $thumb_path;
        }
        $id = data_get($video_data, 'id', false);
        if ($id) {
            $data['updated_at'] = Carbon::now()->format('Y-m-d');
            Video::where('id', $id)->update($data);
        }

        if (!$id) {
            $data['teacher_id'] = auth()->user()->id;
            $data['created_at'] = Carbon::now()->format('Y-m-d');
            $id = Video::insertGetId($data);
            $this->createQuiz($id);
        }
    }
    public function createQuiz($video_id)
    {
        $video = Video::find($video_id);
        $data = [
            'field_id' => $video->field_id,
            'course_id' => $video->course_id,
            'subject_id' => $video->subject_id,
            'lesson_id' => $video->lesson_id,
            'video_id' => $video_id,
            'quiz_name' => $video->video_title,
            'description' => $video->description,
            'quiz-icon' => $video->video_thumb,
        ];
        Quiz::insert($data);
    }
    public function getQuiz($video_id)
    {
        $quiz = Quiz::where('video_id', $video_id)->first();
        if (!$quiz) {
            $this->createQuiz($video_id);
        }
        $lebels = Level::where('field_id', $quiz->field_id)->get();
        $categories = Category::where('field_id', $quiz->field_id)->get();
        return response()->json(['quiz' => $quiz, 'lebels' => $lebels, 'categories' => $categories]);
    }

    public function upload(Request $request, $video_id)
    {
        $data = $request->all();
        $dzchunkindex = data_get($data, 'dzchunkindex');
        $dztotalchunkcount = data_get($data, 'dztotalchunkcount');
        $path = $request->file('file')->store('temp');
        $path = storage_path('app/' . $path);
        $ext = pathinfo($path, PATHINFO_EXTENSION);

        $video = Video::find($video_id);

        if ($dzchunkindex == 0) {
            $video->extension = time().'.'.$ext;
            $video->save();
        }
        $title = str_replace(" ", "_", $video->video_title);
        $video_upload_path = storage_path('app/temp/' . $video_id .$title.  $video->extension);

        $in = fopen($path, 'rb');

        if ($in) {
            if ($dzchunkindex == 0) {
                File::put($video_upload_path, '');
            }
            $content = File::get($path);
            File::append($video_upload_path, $content);
        }
        unlink($path);
        if ($dzchunkindex == ($dztotalchunkcount - 1)) {
            $video_path = 'videos/' . $title . $video->extension;
            $thumb_path = 'video-thumbs/'.$title.time().'.png';
            $video->video = $video_path;
            $video->video_thumb = $thumb_path;
            $video->save();
            $cmd = env('FFMPEG_PATH').' -i '. $video_upload_path. " -frames:v 1 -s 600x320 ".public_path( $thumb_path);
            system($cmd);
            File::move($video_upload_path, $video_path);
        }
        return response()->json(['messge' => 'done']);
    }

    public function videoOfDay() {
        $user = auth()->user();
        $user_course_mapping = UserCourseMapping::where('user_id', $user->id)->first();
        $video_of_day = VideoOfDay::videoOfDay($user_course_mapping->course_id);
        return response()->json(['video_of_day' => $video_of_day]);
    }
}
