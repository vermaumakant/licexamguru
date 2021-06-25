<?php

namespace App\Http\Controllers;

use File;
use Carbon\Carbon;
use App\Models\Course;
use App\Models\UserCourseMapping;
use Illuminate\Http\Request;
use App\Models\UserFieldMapping;

class CourseController extends Controller
{
    public function index(Request $request) {
        $filters = $request->all();
        $courses = Course::getCourse($filters)->paginate(data_get($filters, 'per_page', 20));
        return response()->json(['courses' => $courses]);
    }

    public function mycourse(Request $request) {
        $filters = $request->all();
        $teacher_id = auth()->user()->id;
        $courses = Course::getCourse($filters)->getMyCourse($teacher_id)->paginate(data_get($filters, 'per_page', 20));
        return response()->json(['courses' => $courses]);
    }
    public function find(Request $request, $id) {
        $filters = ['id' => $id];
        $course = Course::getCourse($filters)->first();
        return response()->json(['course' => $course, 'filters' => $filters]);
    }

    public function saveCourse(Request $request) {
        $course_data = $request->all();
        $id = data_get($course_data, 'id', null);
        $course_icon = null;
        $data = [
            'admin_id' => auth()->user()->id,
            'course_name' => data_get($course_data, 'course_name', null),
            'description' => data_get($course_data, 'description', null),
            'field_id' => data_get($course_data, 'field_id', null),
            'updated_at' => Carbon::now()->format('Y-m-d')
        ];
        if($course_data['course_icon']) {
            $data['course_icon'] = $course_data['course_icon'];
        }
        // if(data_get($course_data, 'course_icon', null)) {
        //     $ext = pathinfo(storage_path('app/'.$course_data['course_icon']), PATHINFO_EXTENSION);
        //     $origin_path = storage_path('app/'.$course_data['course_icon']);
        //     if(file_exists($origin_path)) {
        //         $course_icon = 'course-images/'.str_replace(" ", "_", $data['course_name']).'-'.auth()->user()->id.time().".".$ext;
        //         $destination_path = public_path($course_icon);
        //         File::move($origin_path, $destination_path);
        //         $data['course_icon'] = $course_icon;
        //     }
        // }

        if($id) {
            Course::where('id', $id)->update($data);
        }

        if(!$id) {
            $data['created_at'] = Carbon::now()->format('Y-m-d');
            Course::insert($data);
        }
        return response()->json(['message' => 'course created']);
    }

    public function fieldCourses() {
        $user = auth()->user();
        $user_fields=  UserFieldMapping::where('user_id', $user->id)->pluck('field_id');
        $courses = Course::whereIn('field_id', $user_fields)->get();
        
        return response()->json(['courses' => $courses]);
    }

    public function saveUserCourse(Request $request) {
        $course_id = $request->get('course_id');
        $selected = $request->get('selected');
        $user = auth()->user();
        $mapping= UserCourseMapping::where('user_id', $user->id)->where('course_id', $course_id)->withTrashed()->first();
        if ($mapping) {
            if($selected == 'true' || $selected == true) {
                $mapping->restore();
            }
            if($selected == 'false' || $selected == false) {
                $mapping->delete();
            }
        }
        if (!$mapping ) {
            $course = Course::find($course_id);
            $mapping = UserCourseMapping::create([
                'user_id' => $user->id,
                'course_id' => $course_id,
                'field_id' => $course->field_id
                ]);
            $mapping->save();
        }
        return response()->json(['msg' =>"Saved"], 200);
    }

}
