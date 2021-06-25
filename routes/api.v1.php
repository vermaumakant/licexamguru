<?php

use App\Http\Controllers\CommonController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\SubjectController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use App\Models\Quiz;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// config(['auth.guards.api.provider' => 'users']);
Route::get("test", function(){
    return "Okay";
});
Route::post('signup', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::post('check-mobile', [UserController::class, 'checkMobile']);
Route::post('verify-mobile', [UserController::class, 'verifyMobileOtp']);
Route::middleware('auth:api')->group(function () {
    Route::get('getuser-basic-details', [UserController::class, 'userDetails']);
    Route::get('fields',[FieldController::class, 'getFields']);
    Route::post('save-user-field', [FieldController::class, 'saveUserField']);
    Route::get('countries', [CommonController::class, 'getCountries']);

    Route::post('save-study-details', [UserController::class, 'saveStudyDetails']);
    Route::get('field-courses', [CourseController::class, 'fieldCourses']);
    Route::post('save-user-course', [CourseController::class, 'saveUserCourse']);

    Route::get('video-of-day', [VideoController::class, 'videoOfDay']); 
    Route::get('free-videos', [VideoController::class, "freeVideos"]);

    Route::get('subjects', [SubjectController::class, 'getUserSubjects']);
    Route::get('topics/{course_id}/{subject_id}', [LessonController::class, 'index']);
    Route::get('videos/{course_id}/{subject_id}/{lesson_id}', [VideoController::class, 'index']);
    Route::get('quizes/{course_id}/{subject_id}/{lesson_id}', [QuizController::class, 'getQuizes']);
    Route::get('questions/{quiz_id}', [QuizController::class, 'getQuestions']);
    Route::get('question/{quiz_id}/skip/{skip}', [QuizController::class, 'getQuestion']);

});