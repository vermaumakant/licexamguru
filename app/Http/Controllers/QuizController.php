<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizReport;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function getQuizes($course_id, $subject_id, $lesson_id) {
        $query = Quiz::getQuizes($course_id, $subject_id, $lesson_id);
        $quizes = $query->get();
        return response()->json(['quizes' => $quizes]);
    }

    public function getQuestions($quiz_id) {
        $quiz_report = QuizReport::where('quiz_id', $quiz_id)->where('user_id',  auth()->user()->id)->first();
        if(!$quiz_report) {
            $quiz_report  = QuizReport::create([
                'quiz_id' => $quiz_id,
                'user_id' => auth()->user()->id
            ]);
        }
        $query = Quiz::findQuiz($quiz_id);
        $quiz = $query->first();
        $question = QuizQuestion::getQuestion($quiz_id,0);
        return response()->json([
            'quiz' => $quiz,
            'question' => $question,
            'quiz_report' => $quiz_report
        ]);
    }

    public function getQuestion($quiz_id, $skip = 0) {
        $question = QuizQuestion::getQuestion($quiz_id, $skip);
        QuizReport::updateCurrentQuestion($quiz_id, $skip, auth()->user()->id);
        return response()->json(['question' => $question]);
    }
}
