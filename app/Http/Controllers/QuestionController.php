<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Level;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\Subject;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {}

    public function seveQuestion(Request $request)
    {
        $data = $request->all();
        $id = data_get($data, 'id');
        unset($data['id']);
        unset($data['field_id']);
        if ($id) {
            QuizQuestion::where('id', $id)->update($data);
        }
        if (!$id) {
            QuizQuestion::insert($data);
        }
        return response()->json(['message' => 'saved']);
    }

    public function getQuestions($quiz_id)
    {
        $quiz = Quiz::find($quiz_id);
        $questions = QuizQuestion::where('quiz_id', $quiz_id)->get();
        return response()->json(['questions' => $questions, 'quiz' => $quiz]);
    }

    public function findQuestion($question_id)
    {
        $question = QuizQuestion::leftJoin('quizzes', 'quiz_questions.quiz_id', 'quizzes.id')
            ->where('quiz_questions.id', $question_id)
            ->select('quiz_questions.*', 'quizzes.field_id')
            ->first();
        $lebels = Level::where('field_id', $question->field_id)->get();
        $categories = Category::where('field_id', $question->field_id)->get();
        return response()->json(['question' => $question, 'lebels' => $lebels, 'categories' => $categories]);
    }

    public function createQuiz(Request $request)
    {
        $request_data = $request->all();
        $subject = Subject::find($request_data['subject_id']);
        $data = [
            'field_id' => $subject->field_id,
            'course_id' => $subject->course_id,
            'subject_id' => $subject->id,
            'quiz_name' => data_get($request_data, 'quiz_name'),
            'description' => data_get($request_data, 'description'),
            'quiz_type' => data_get($request_data, 'quiz_type'),
        ];
        $id = data_get($request_data, 'id');
        if ($id) {
            Quiz::where('id', $id)->update($data);
        }
        if(!$id) {
            Quiz::insert($data);
        }
        return response()->json(['message' => 'Saved']);
    }

    public function getQuizList(Request $request) {
        $request_data = $request->all();
        $subject_id = data_get($request_data, 'subject_id');
        $quiz_type = data_get($request_data, 'quiz_type');
        $quizzes = Quiz::where('subject_id', $subject_id)->where('quiz_type', $quiz_type)->get();
        return response()->json(['quizzes' => $quizzes]);
    }
}
