<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ApiQuizController extends Controller
{
    public function sendQuiz() {
        // NOTE : DISABLE VERIFY GUZZLE IN VENDOR
        $response = Http::get('https://opentdb.com/api.php?amount=10&category=18&type=multiple');
        
        return response(json_decode($response, true), 200);
    }

    public function getAllQuizByUser() {
        $validator = Validator::make(["id" => auth()->user()['id']], [
            'id' => 'exists:users,id',
        ]);
        if ($validator->fails())
            return response(['errors'=>$validator->errors()->all()], 422);
    
        $quiz = Quiz::where('userId', auth()->user()['id'])->get();
        
        return response($quiz, 200);
    }

    public function getOneQuizById($id) {
        $validator = Validator::make(["id" => $id], [
            'id' => 'exists:quizzes,id',
        ]);
        if ($validator->fails())
            return response(['errors'=>$validator->errors()->all()], 422);
    
        $quiz = Quiz::where('id', $id)->first();
        
        return response($quiz, 200);
    }

    public function addQuiz(Request $request) {
        $validator = Validator::make($request->all(), [
            'choices' => 'required|array|size:10',
            'choices.*' => Rule::in(['a','b','c','d', null]),
            'question' => 'required|array|size:10',
            'question.*.answers' => 'required|array|size:4',
            'question.*.category' => 'required|string',
            'question.*.correct_answer' => 'required|string',
            'question.*.difficulty' => 'required|string',
            'question.*.incorrect_answers' => 'required|array|size:3',
            'question.*.question' => 'required|string',
            'question.*.type' => 'required|string',
        ]);
        if ($validator->fails())
            return response(['errors'=>$validator->errors()->all()], 422);
    
        
    }
}
