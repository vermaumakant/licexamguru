<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use File;
class LessonController extends Controller
{
    public function index($course_id, $subject_id) {
        $query = Lesson::getLessions($course_id, $subject_id);
        if(auth()->user()->admin_type == 'teacher') {
            $query->where('lessons.teacher_id', auth()->user()->id);
        }
        $lessons = $query->get();
        return response()->json(['lessons' => $lessons]);
    }

    public function find($course_id, $subject_id, $lesson_id) {
        $lesson = Lesson::getLessions($course_id, $subject_id)
            ->where('lessons.id', $lesson_id)
            ->first();
        return response()->json(['lesson' => $lesson]);
    }

    public function saveLesson(Request $request, $course_id, $subject_id) {
        $lession_data = $request->all();
        $subject = Subject::find($subject_id);
        $data = [
            'field_id' => $subject->field_id,
            'course_id' => $course_id,
            'subject_id' => $subject_id,
            'lesson_name' => data_get($lession_data, 'lesson_name'),
            'lesson_icon' => data_get($lession_data, 'lesson_icon'), 
            'description' => data_get($lession_data, 'description'), 
        ];
        $lesson_icon = data_get($lession_data, 'lesson_icon', false);
        if($lesson_icon) {
            $origin_path = storage_path('app/'.$lesson_icon);
            if(file_exists($origin_path)) {
                $ext = pathinfo(storage_path('app/'.$lesson_icon), PATHINFO_EXTENSION);
                $subject_icon = 'lesson-images/'.str_replace(" ", "_", $data['lesson_name']).'-'.auth()->user()->id.time().".".$ext;
                $destination_path = public_path($subject_icon);
                File::move($origin_path, $destination_path);
                $data['lesson_icon'] = $subject_icon;
            }
        }
        $id = data_get($lession_data, 'id', false);
        if($id) {
            $data['updated_at'] = Carbon::now()->format('Y-m-d');
            Lesson::where('id', $id)->update($data);
        }

        if(!$id) {
            $data['teacher_id'] = auth()->user()->id;
            $data['created_at'] = Carbon::now()->format('Y-m-d');
            Lesson::insert($data);
        }
        return response()->json(['message' => 'lesson saved']);
    }
}
