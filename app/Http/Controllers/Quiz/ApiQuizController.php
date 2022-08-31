<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Services\AnsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\QuizService;
use Error;

class ApiQuizController extends Controller
{
    private QuizService $quizService;
    private AnsService $ansService;

    public function __construct(QuizService $quizService, AnsService $ansService) 
    {   
        $this->quizService = $quizService;
        $this->ansService = $ansService;
    }

    public function sendQuiz() {
        // NOTE : DISABLE VERIFY GUZZLE IN VENDOR
        $response = Http::get('https://opentdb.com/api.php?amount=10&category=18&type=multiple');
        
        return response(json_decode($response, true), 200);
    }

    public function getAllQuizByUser() {
        try {
            $quiz = $this->quizService->getAllQuizByUser(auth()->user()['id']);
            
            return response($quiz, $quiz['status'] ?? 200);
        } catch (Error $err) {
            return response(["Message" => "Internal Server Error"], 500);
        }
    }

    public function getQuizById($id) {
        try {
            $quiz = $this->quizService->getQuizById($id);
            
            return response($quiz, $quiz['status'] ?? 200);
        } catch (Error $err) {
            return response(["Message" => "Internal Server Error"], 500);
        }
    }

    public function addQuiz(Request $request) {
        try {
            $quiz = $this->quizService->addQuiz($request);

            $request['quizId'] = $quiz['id'];
            $ans = $this->ansService->addManyAns($request);

            $quiz = $this->quizService->updateScoreQuiz($quiz['id']);

            $status = $quiz['status'] ?? 200;
            $status == 200 ? $status = $ans['status'] ?? 200 : null;

            return response(['Quiz' => $quiz, 'Ans' => $ans], $status);
        } catch (Error $err) {
            return response(["Message" => "Internal Server Error"], 500);
        }
    }
}
