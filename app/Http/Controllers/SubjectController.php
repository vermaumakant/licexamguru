<?php

namespace App\Http\Controllers;

use File;
use Carbon\Carbon;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\UserCourseMapping;
use App\Models\Video;

class SubjectController extends Controller
{
    public function index($course_id = null) {
        $query = Subject::getSubjects($course_id);
        if(auth()->user()->admin_type == 'teacher') {
            $query->where('teacher_id', auth()->user()->id);
        }
        $subjects = $query->get();
        return response()->json(['subjects' => $subjects]);
    }


    public function find($course_id, $subject_id) {
        $subject = Subject::getSubjects($course_id)
            ->where('subjects.id', $subject_id)
            ->first();
        return response()->json(['subject' => $subject]);
    }

    public function saveSubject(Request $request, $course_id) {
        $subject_data = $request->all();
        $course = Course::find($course_id);
        $data = [
            "field_id" => $course->field_id,
            "course_id" => $course_id,
            "subject_name" => data_get($subject_data, 'subject_name'),
            "description" => data_get($subject_data, 'description'),
        ];
        $subject_icon = data_get($subject_data, 'subject_icon', false);
        if($subject_icon) {
            $origin_path = storage_path('app/'.$subject_icon);
            if(file_exists($origin_path)) {
                $ext = pathinfo(storage_path('app/'.$subject_icon), PATHINFO_EXTENSION);
                $subject_icon = 'subject-images/'.str_replace(" ", "_", $data['subject_name']).'-'.auth()->user()->id.time().".".$ext;
                $destination_path = public_path($subject_icon);
                File::move($origin_path, $destination_path);
                $data['subject_icon'] = $subject_icon;
            }
        }
        $id = data_get($subject_data, 'id', false);
        if($id) {
            $data['updated_by'] = auth()->user()->id;
            $data['updated_at'] = Carbon::now()->format('Y-m-d');
            Subject::where('id', $id)->update($data);
        }

        if(!$id) {
            $data['teacher_id'] = auth()->user()->id;
            $data['created_at'] = Carbon::now()->format('Y-m-d');
            Subject::insert($data);
        }
        return response()->json(['message' => 'Subject saved']);
    }

    public function getUserSubjects() {
        $user = auth()->user();
        $user_course_mapping = UserCourseMapping::where('user_id', $user->id)->first();
        $course_id = $user_course_mapping->course_id;
        $query = Subject::getSubjects($course_id);
        $subjects = $query->get();
        foreach ($subjects as $key => $subject) {
            $subjects[$key]['lessions'] = Lesson::where('subject_id', $subject->id)->where('course_id', $course_id)->count();
            $subjects[$key]['videos'] = Video::where('subject_id', $subject->id)->where('course_id', $course_id)->count();
        }
        return response()->json(['subjects' => $subjects]);
    }
}
