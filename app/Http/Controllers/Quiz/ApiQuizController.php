<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ApiQuizController extends Controller
{
    public function sendQuiz() {
        // NOTE : DISABLE VERIFY GUZZLE IN VENDOR
        $response = Http::get('https://opentdb.com/api.php?amount=10&category=18');

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
}
