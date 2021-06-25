<?php

use App\Http\Controllers\CommonController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

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
config(['auth.guards.api.provider' => 'admins']);

Route::post('/login', [UserController::class, 'login']);
Route::post('upload', [CommonController::class, 'upload']);
Route::post('upload/public', [CommonController::class, 'uploadPublic']);
Route::post('upload/icons', [CommonController::class, 'uploadIcons']);
Route::post('upload/video/chunk/{video_id}', [VideoController::class, 'upload']);

Route::middleware('auth:api')->group(function () {
    Route::get('info', [UserController::class, 'info']);
    Route::post('logout', [UserController::class, 'logout']);
    Route::get('fields', [FieldController::class, 'index']);
    Route::post('fields', [FieldController::class, 'saveField']);
    Route::post('fields/addlevel', [FieldController::class, 'addlevel']);
    Route::post('fields/category', [FieldController::class, 'addCategoty']);
    Route::get('levels/{field_id}', [FieldController::class, 'lebels']);
    Route::get('vodeo/quiz/{vodeo_id}', [VideoController::class, 'getQuiz']);
    Route::get('icons', [CommonController::class, 'loadIcons']);
    Route::prefix('courses')->group(function () {
        Route::get('/', [CourseController::class, 'index']);
        Route::post('/', [CourseController::class, 'saveCourse']);

        Route::prefix('/{course_id}')->group(function () {
            Route::get('/', [CourseController::class, 'find']);
            Route::prefix('subjects')->group(function () {
                Route::get('/', [SubjectController::class, 'index']);
                Route::post('/', [SubjectController::class, 'saveSubject']);
                Route::prefix('/{subject_id}')->group(function () {
                    Route::get('/', [SubjectController::class, 'find']);
                    Route::get('/free-videos', [VideoController::class, 'freeVideos']);
                    Route::post('/save-promo-videos', [VideoController::class, 'saveVideo']);
                    Route::get('add-rivision-videos', [VideoController::class, 'index']);
                    Route::post('add-rivision-videos', [VideoController::class, 'addRevisionVideo']);
                    Route::prefix('lessons')->group(function () {
                        Route::get('/', [LessonController::class, 'index']);
                        Route::post('/', [LessonController::class, 'saveLesson']);
                        Route::prefix('/{lesson_id}')->group(function () {
                            Route::get('/', [LessonController::class, 'find']);
                            Route::prefix('videos')->group(function () {
                                Route::get('/', [VideoController::class, 'index']);
                                Route::post('/', [VideoController::class, 'saveVideo']);
                                Route::prefix('/{video_id}')->group(function () {
                                    Route::get('/', [VideoController::class, 'find']);
                                });
                            });
                        });
                    });
                });

            });
        });
    });

    Route::get('mycourse', [CourseController::class, 'mycourse']);

    Route::prefix('autocomplete')->group(function () {
        Route::get('/teacher', [TeacherController::class, 'search']);
    });

    Route::get('mysubjects', [SubjectController::class, 'index']);
    Route::get('teachers', [TeacherController::class, 'index']);
    Route::post('teachers', [TeacherController::class, 'saveTeacher']);

    Route::prefix('quiz')->group(function () {
        Route::get('/', [QuestionController::class, 'getQuizList']);
        Route::post('create', [QuestionController::class, 'createQuiz']);
        Route::get('/questions/{quiz_id}', [QuestionController::class, 'getQuestions']);
        Route::get('/question/{question_id}', [QuestionController::class, 'findQuestion']);
        Route::post('add-question', [QuestionController::class, 'seveQuestion']);
    });

    Route::prefix('subscription')->group(function () {
        Route::get('/', [SubscriptionController::class, 'index']);
        Route::post('/', [SubscriptionController::class, 'saveSubscription']);
        Route::prefix('/{subscription_id}')->group(function () {
            Route::get('find', [SubscriptionController::class, 'find']);
            Route::get('courses', [SubscriptionController::class, 'courses']);
            Route::post('update-step', [SubscriptionController::class, 'updateStep']);
            Route::post('add-course/{course_id}', [SubscriptionController::class, 'addCourse']);
            Route::post('remove-course/{course_id}', [SubscriptionController::class, 'removeCourse']);

            Route::get('subjects', [SubscriptionController::class, 'getSubjects']);
            Route::post('add-subject/{subject_id}', [SubscriptionController::class, 'addSubjects']);
            Route::post('remove-subject/{subject_id}', [SubscriptionController::class, 'removeSubjects']);

            Route:: get('subject-lessons', [SubscriptionController::class, 'getLessons']);
            Route::post('add-lesson/{lesson_id}', [SubscriptionController::class, 'addlessons']);
            Route::post('remove-lesson/{lesson_id}', [SubscriptionController::class, 'removelessons']);

            Route:: get('lesson-videos', [SubscriptionController::class, 'getLessonVideos']);
            Route::post('add-lesson-video/{lesson_id}', [SubscriptionController::class, 'addlessonVideo']);
            Route::post('remove-lesson-video/{lesson_id}', [SubscriptionController::class, 'removelessonVideo']);

            Route:: get('lesson-quiz', [SubscriptionController::class, 'getLessonQuiz']);
            Route::post('add-remove-quiz', [SubscriptionController::class, 'addRemoveQuiz']);
            
            Route:: get('subject-quiz/{type}', [SubscriptionController::class, 'getSubjestQuiz']);
            Route:: get('revision-videos', [SubscriptionController::class, 'getRevisionVideos']);

            Route::get('summary', [SubscriptionController::class, 'getSummary']);
            Route::post('publish', [SubscriptionController::class, 'publish']);
        });
    });
});
