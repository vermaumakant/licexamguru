<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\Subject;
use App\Models\Subscription;
use App\Models\SubscriptionCourseMapping;
use App\Models\SubscriptionLessonMapping;
use App\Models\SubscriptionQuizMapping;
use App\Models\SubscriptionSubjectMapping;
use App\Models\SubscriptionVideoMapping;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::get();
        return response()->json(['subscriptions' => $subscriptions]);
    }

    public function saveSubscription(Request $request)
    {
        $data = $request->all();
        $id = data_get($data, 'id');
        unset($data['id']);
        if ($id) {
            $data['updated_at'] = Carbon::now()->format('Y-m-d');
            Subscription::where('id', $id)->update($data);
        }
        if (!$id) {
            $data['created_at'] = Carbon::now()->format('Y-m-d');
            Subscription::insert($data);
        }
        return response()->json(['message' => 'saved']);
    }

    public function find($subscription_id)
    {
        $subscription = Subscription::find($subscription_id);
        return response()->json(['subscription' => $subscription]);
    }

    public function courses(Request $request, $subscription_id)
    {
        $filters = $request->all();
        $subscription = Subscription::find($subscription_id);
        $all_courses = Course::getCourse(['filed_id' => $subscription->field_id])->paginate(data_get($filters, 'per_page', 20));
        $subscribed_courses = SubscriptionCourseMapping::where('subscription_id', $subscription_id)->get();
        foreach ($all_courses as $key => $courses) {
            $subscribed_course = $subscribed_courses->firstWhere('course_id', $courses->id);
            $all_courses[$key]->subscribed = optional($subscribed_course)->id ? true : false;
        }
        return response()->json(['courses' => $all_courses]);
    }

    public function addCourse($subscription_id, $course_id)
    {
        $mapping = SubscriptionCourseMapping::withTrashed()
            ->where('subscription_id', $subscription_id)
            ->where('course_id', $course_id)
            ->first();
        if ($mapping) {
            $mapping->restore();
        }
        if (!$mapping) {
            $mapping = SubscriptionCourseMapping::create(['subscription_id' => $subscription_id, 'course_id' => $course_id]);
            $mapping->save();
        }
        return response()->json(['message' => 'added']);
    }

    public function removeCourse($subscription_id, $course_id)
    {
        SubscriptionCourseMapping::where('subscription_id', $subscription_id)
            ->where('course_id', $course_id)
            ->delete();

        return response()->json(['message' => 'removed']);
    }

    public function updateStep($subscription_id)
    {
        $subscription = Subscription::find($subscription_id);
        $subscription->subscription_step += 1;
        $subscription->save();
        return response()->json(['message' => 'done']);
    }

    public function getSubjects($subscription_id)
    {
        $course_ids = SubscriptionCourseMapping::where('subscription_id', $subscription_id)->pluck('course_id');
        $subscribed_subjects = SubscriptionSubjectMapping::where('subscription_id', $subscription_id)->get();
        $course_wise_subjects = [];
        foreach ($course_ids as $key => $course_id) {
            $course_all_subjects = Subject::getSubjects($course_id)->get();
            if ($course_all_subjects->count() == 0) {
                continue;
            }
            foreach ($course_all_subjects as $key => $subject) {
                $subscribed_subject = $subscribed_subjects->firstWhere('course_id', $subject->id);
                $course_all_subjects[$key]->subscribed = optional($subscribed_subject)->id ? true : false;
            }
            $course_wise_subjects[$course_id] = [
                'course_name' => Course::find($course_id)->course_name,
                'subjects' => $course_all_subjects,
            ];
        }
        return response()->json(['course_subjects' => $course_wise_subjects]);
    }

    public function addSubjects($subscription_id, $subject_id)
    {
        $mapping = SubscriptionSubjectMapping::withTrashed()
            ->where('subscription_id', $subscription_id)
            ->where('subject_id', $subject_id)
            ->first();
        if ($mapping) {
            $mapping->restore();
        }
        if (!$mapping) {
            $subject = Subject::find($subject_id);
            $mapping = SubscriptionSubjectMapping::create([
                'subscription_id' => $subscription_id,
                'course_id' => $subject->course_id,
                'subject_id' => $subject_id,
            ]);
            $mapping->save();
        }
        return response()->json(['message' => 'added']);
    }
    public function removeSubjects($subscription_id, $subject_id)
    {
        SubscriptionSubjectMapping::where('subscription_id', $subscription_id)
            ->where('subject_id', $subject_id)
            ->delete();
    }

    public function getlessons($subscription_id)
    {
        $subject_ids = SubscriptionSubjectMapping::where('subscription_id', $subscription_id)->pluck('subject_id');
        $subscribed_lessons = SubscriptionLessonMapping::where('subscription_id', $subscription_id)->get();
        $subject_wise_lessons = [];
        foreach ($subject_ids as $key => $subject_id) {
            $subject_all_lessons = Lesson::where('subject_id', $subject_id)->get();
            if ($subject_all_lessons->count() == 0) {
                continue;
            }
            foreach ($subject_all_lessons as $key => $lesson) {
                $subscribed_lesson = $subscribed_lessons->firstWhere('lesson_id', $lesson->id);
                $subject_all_lessons[$key]->subscribed = optional($subscribed_lesson)->id ? true : false;
            }
            $subject = Subject::findSubject($subject_id);
            $subject_wise_lessons[$subject_id] = [
                'course_name' => $subject->course_name,
                'subject_name' => $subject->subject_name,
                'lessons' => $subject_all_lessons,
            ];
        }
        return response()->json(['subject_lessons' => $subject_wise_lessons]);
    }

    public function addlessons($subscription_id, $lesson_id)
    {
        $mapping = SubscriptionLessonMapping::withTrashed()
            ->where('subscription_id', $subscription_id)
            ->where('lesson_id', $lesson_id)
            ->first();
        if ($mapping) {
            $mapping->restore();
        }
        if (!$mapping) {
            $lesson = Lesson::find($lesson_id);
            $mapping = SubscriptionLessonMapping::create([
                'subscription_id' => $subscription_id,
                'course_id' => $lesson->course_id,
                'subject_id' => $lesson->subject_id,
                'lesson_id' => $lesson_id,
            ]);
            $mapping->save();
        }
        return response()->json(['message' => 'added']);
    }
    public function removelessons($subscription_id, $lesson_id)
    {
        SubscriptionLessonMapping::where('subscription_id', $subscription_id)
            ->where('lesson_id', $lesson_id)
            ->delete();
    }

    public function getLessonVideos($subscription_id)
    {
        $lesson_ids = SubscriptionLessonMapping::where('subscription_id', $subscription_id)->pluck('lesson_id');
        $subscribed_videos = SubscriptionVideoMapping::where('subscription_id', $subscription_id)
            ->whereIn('lesson_id', $lesson_ids)
            ->get();
        $lesson_wise_videos = [];
        foreach ($lesson_ids as $key => $lesson_id) {
            $lesson_all_videos = Video::where('lesson_id', $lesson_id)->get();
            if ($lesson_all_videos->count() == 0) {
                continue;
            }
            foreach ($lesson_all_videos as $key => $video) {
                $subscribed_video = $subscribed_videos->firstWhere('video_id', $video->id);
                $lesson_all_videos[$key]->subscribed = optional($subscribed_video)->id ? true : false;
            }
            $lesson = Lesson::findLesson($lesson_id);
            $lesson_wise_videos[$lesson_id] = [
                'course_name' => $lesson->course_name,
                'subject_name' => $lesson->subject_name,
                'lesson_name' => $lesson->lesson_name,
                'videos' => $lesson_all_videos,
            ];
        }
        return response()->json(['lesson_videos' => $lesson_wise_videos]);
    }

    public function addlessonVideo($subscription_id, $video_id)
    {
        $mapping = SubscriptionVideoMapping::withTrashed()
            ->where('subscription_id', $subscription_id)
            ->where('video_id', $video_id)
            ->first();
        if ($mapping) {
            $mapping->restore();
        }
        if (!$mapping) {
            $video = Video::find($video_id);
            $mapping = SubscriptionVideoMapping::create([
                'subscription_id' => $subscription_id,
                'course_id' => $video->course_id,
                'subject_id' => $video->subject_id,
                'lesson_id' => $video->lesson_id,
                'video_id' => $video_id,
            ]);
            $mapping->save();
        }
        return response()->json(['message' => 'saved']);
    }
    public function removelessonVideo($subscription_id, $video_id)
    {
        SubscriptionVideoMapping::where('subscription_id', $subscription_id)
            ->where('video_id', $video_id)
            ->delete();
    }

    public function getLessonQuiz($subscription_id)
    {
        $lesson_ids = SubscriptionLessonMapping::where('subscription_id', $subscription_id)->pluck('lesson_id');
        $subscribed_quizs = SubscriptionQuizMapping::where('subscription_id', $subscription_id)->get();
        $video_wise_quiz = [];
        foreach ($lesson_ids as $key => $lesson_id) {
            $video_all_quizs = Quiz::where('lesson_id', $lesson_id)
                ->where('quiz_type', 'video')
                ->get();
            if ($video_all_quizs->count() == 0) {
                continue;
            }
            foreach ($video_all_quizs as $key => $quiz) {
                $subscribed_quiz = $subscribed_quizs->firstWhere('quiz_id', $quiz->id);
                $video_all_quizs[$key]->subscribed = optional($subscribed_quiz)->id ? true : false;
            }
            $lesson = Lesson::findLesson($lesson_id);
            $video_wise_quiz[] = [
                'course_name' => $lesson->course_name,
                'subject_name' => $lesson->subject_name,
                'lesson_name' => $lesson->lesson_name,
                'lesson_id' => $lesson_id,
                'quiz' => $video_all_quizs,
            ];
        }
        return response()->json(['video_quiz' => $video_wise_quiz]);
    }

    public function addRemoveQuiz(Request $request, $subscription_id)
    {
        $data = $request->all();
        $quiz_type = data_get($data, 'quiz_type');
        $query = SubscriptionQuizMapping::where('subscription_id', $subscription_id);
        if (data_get($data, 'lesson_id')) {
            $query->where('lesson_id', $data['lesson_id']);
            $query->delete();
        }

        if (data_get($data, 'subject_id')) {
            $subject_ids = Quiz::where('subject_id', $data['subject_id'])->where('quiz_type', $quiz_type)->pluck('id');
            $query->whereIn('subject_id', $subject_ids)->whereNull('video_id')->whereNull('lesson_id');
            $query->delete();
        }

        $subscribed_quiz = $data['subscribed_quiz'];
        foreach ($subscribed_quiz as $key => $quiz_id) {
            $mapping = SubscriptionQuizMapping::withTrashed()
                ->where('subscription_id', $subscription_id)
                ->where('quiz_id', $quiz_id)
                ->first();
            if ($mapping) {
                $mapping->restore();
            }
            if (!$mapping) {
                $quiz = Quiz::find($quiz_id);
                $mapping = SubscriptionQuizMapping::create([
                    'subscription_id' => $subscription_id,
                    'course_id' => $quiz->course_id,
                    'subject_id' => $quiz->subject_id,
                    'lesson_id' => $quiz->lesson_id,
                    'video_id' => $quiz->video_id,
                    'quiz_id' => $quiz_id,
                ]);
                $mapping->save();
            }
        }
        return response()->json(['message' => 'added']);
    }

    public function getSubjestQuiz($subscription_id, $quiz_type)
    {
        $subject_ids = SubscriptionSubjectMapping::where('subscription_id', $subscription_id)->pluck('subject_id');
        $subscribed_quizs = SubscriptionQuizMapping::where('subscription_id', $subscription_id)
            ->whereIn('subject_id', $subject_ids)
            ->get();
        $subject_wise_quiz = [];
        foreach ($subject_ids as $key => $subject_id) {
            $video_all_quizs = Quiz::where('subject_id', $subject_id)
                ->where('quiz_type', $quiz_type)
                ->whereNull('video_id')
                ->whereNull('lesson_id')
                ->get();
            if ($video_all_quizs->count() == 0) {
                continue;
            }
            foreach ($video_all_quizs as $key => $quiz) {
                $subscribed_quiz = $subscribed_quizs->firstWhere('quiz_id', $quiz->id);
                $video_all_quizs[$key]->subscribed = optional($subscribed_quiz)->id ? true : false;
            }
            $subject = Subject::findSubject($subject_id);
            $subject_wise_quiz[] = [
                'course_name' => $subject->course_name,
                'subject_name' => $subject->subject_name,
                'subject_id' => $subject_id,
                'quiz' => $video_all_quizs,
            ];
        }
        return response()->json(['exam_quiz' => $subject_wise_quiz]);
    }

    public function getRevisionVideos($subscription_id)
    {
        $subject_ids = SubscriptionSubjectMapping::where('subscription_id', $subscription_id)->pluck('subject_id');
        $subscribed_videos = SubscriptionVideoMapping::where('subscription_id', $subscription_id)
            ->whereIn('subject_id', $subject_ids)
            ->whereNull('lesson_id')
            ->get();
        $revision_videos = [];
        foreach ($subject_ids as $key => $subject_id) {
            $revision_all_videos = Video::where('subject_id', $subject_id)->whereNull('lesson_id')->get();
            if ($revision_all_videos->count() == 0) {
                continue;
            }
            foreach ($revision_all_videos as $key => $video) {
                $subscribed_video = $subscribed_videos->firstWhere('video_id', $video->id);
                $revision_all_videos[$key]->subscribed = optional($subscribed_video)->id ? true : false;
            }
            $subject = Subject::findSubject($subject_id);
            $revision_videos[$subject_id] = [
                'course_name' => $subject->course_name,
                'subject_name' => $subject->subject_name,
                'videos' => $revision_all_videos,
            ];
        }
        return response()->json(['revision_videos' => $revision_videos]);
    }

    public function getSummary($subscription_id)
    {
        $subscrition = Subscription::leftJoin('fields', 'subscriptions.field_id', 'fields.id')->where('subscriptions.id', $subscription_id)->first();
        $quiz_counts = [
            'video' => 0,
            'privious-year' => 0,
            'mock-test' => 0,
        ];
        $quizes = SubscriptionQuizMapping::leftJoin('quizzes', 'subscription_quiz_mappings.quiz_id', 'quizzes.id')
            ->where('subscription_quiz_mappings.subscription_id', $subscription_id)
            ->selectRaw('quizzes.quiz_type, COUNT(subscription_quiz_mappings.id) as counts')
            ->groupBy('quizzes.quiz_type')
            ->get();
        if ($quizes) {
            foreach ($quizes as $key => $quiz) {
                $quiz_counts[$quiz->quiz_type] = $quiz->counts;
            }
        }
        $data = [
            ['name' => 'Courses', 'counts' => SubscriptionCourseMapping::where('subscription_id', $subscription_id)->count()],
            ['name' => 'Subjects', 'counts' => SubscriptionSubjectMapping::where('subscription_id', $subscription_id)->count()],
            ['name' => 'Lessons', 'counts' => SubscriptionLessonMapping::where('subscription_id', $subscription_id)->count()],
            ['name' => 'Lesson Videoes', 'counts' => SubscriptionVideoMapping::where('subscription_id', $subscription_id)->whereNotNull('lesson_id')->count()],
            ['name' => 'Video Quizzes', 'counts' => data_get($quiz_counts, 'video')],
            ['name' => 'Privious Exam Quizzes', 'counts' => data_get($quiz_counts, 'privious-year')],
            ['name' => 'Mock Test Quizzes', 'counts' => data_get($quiz_counts, 'mock-test')],
            ['name' => 'Revision Videos', 'counts' => SubscriptionVideoMapping::where('subscription_id', $subscription_id)->whereNull('lesson_id')->count()],
        ];
        return response()->json(['summaries' => $data, 'subscrition' => $subscrition]);
    }

    public function publish($subscription_id) {
        $subscription = Subscription::find($subscription_id);
        $subscription->subscription_step = 9;
        $subscription->status = "published";
        $subscription->save();
        return response()->json(['message' => 'published']);
    }
}
