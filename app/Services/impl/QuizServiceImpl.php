<?php

namespace App\Services\impl;

use App\Models\Answer;
use App\Models\Quiz;
use App\Services\QuizService;
use Carbon\Carbon;
use Error;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class QuizServiceImpl implements QuizService
{
    public function getAllQuizByUser($userId) {
        try {
            $validator = Validator::make(["id" => $userId], [
                'id' => 'exists:users,id',
            ]);
            if ($validator->fails())
                return (['errors'=>$validator->errors()->all(), 'status' => 422]);

            $quiz = Quiz::where('userId', $userId)->get();

            return $quiz;
        } catch (Error $err) {
            $err['status'] = 404;
            return $err;
        }
    }

    public function getQuizById($id) {
        try {
            $validator = Validator::make(["id" => $id], [
                'id' => 'exists:quizzes,id',
            ]);
            if ($validator->fails())
                return (['errors'=>$validator->errors()->all(), 'status' => 422]);

            $quiz = Quiz::where('id', $id)->first();

            return $quiz;
        } catch (Error $err) {
            $err['status'] = 404;
            return $err;
        }
    }

    public function addQuiz($data) {
        try {
            $validator = Validator::make($data->all(), [
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
                'userId' => 'required|integer|exists:users,id'
            ]);
            if ($validator->fails())
                return (['errors'=>$validator->errors()->all(), 'status' => 422]);

            $quiz = Quiz::create(["userId" => $data['userId'], "start" => Carbon::now(), "end" => Carbon::now(), "correct" => 0, "wrong" => 0, "score" => 0]);

            return $quiz;
        } catch (Error $err) {
            $err['status'] = 500;
            return $err;
        }
    }

    public function updateScoreQuiz($id) {
        try {
            $validator = Validator::make(['id' => $id], [
                'id' => 'required|integer|exists:quizzes,id'
            ]);
            if ($validator->fails())
                return (['errors'=>$validator->errors()->all(), 'status' => 422]);
            
            $quiz = Quiz::where('id', $id)->first();
            $ans = Answer::where('quizId', $id)->get();
            foreach ($ans as $data) {
                if ($data['status']) {
                    $quiz['correct'] = $quiz['correct'] + 1;
                    $quiz['score'] = $quiz['score'] + 10;
                } else {
                    $quiz['wrong'] = $quiz['wrong'] + 1;
                }
            }
    
            $quiz->save();
    
            return $quiz;
        } catch (Error $err) {
            return $err;
        }
    }
}