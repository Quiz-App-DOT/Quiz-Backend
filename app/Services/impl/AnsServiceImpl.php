<?php

namespace App\Services\impl;

use App\Models\Answer;
use App\Services\AnsService;
use Error;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AnsServiceImpl implements AnsService
{
    public function getAllAnsByQuizId($id) {
        try {
            $validator = Validator::make(['id' => $id], [
                'id' => 'required|integer|exists:quizzes,id'
            ]);
            if ($validator->fails())
                return (['errors'=>$validator->errors()->all(), 'status' => 422]);
            
            $result = Answer::where('quizId', $id)->get();

            return $result;
        } catch (Error $err) {
            return $err;
        }
    }

    public function addOneAns($ans) {
        try {
            
        } catch (Error $err) {
            return $err;
        }
    }

    public function addManyAns($ans) {
        try {
            $validator = Validator::make($ans->all(), [
                'choices' => 'required|array|size:10',
                'choices.*' => Rule::in(['a','b','c','d',null]),
                'question' => 'required|array|size:10',
                'question.*.answers' => 'required|array|size:4',
                'question.*.category' => 'required|string',
                'question.*.correct_answer' => 'required|string',
                'question.*.difficulty' => 'required|string',
                'question.*.incorrect_answers' => 'required|array|size:3',
                'question.*.question' => 'required|string',
                'question.*.type' => 'required|string',
                'userId' => 'required|integer|exists:users,id',
                'quizId' => 'required|integer|exists:quizzes,id',
            ]);
            if ($validator->fails())
                return (['errors'=>$validator->errors()->all(), 'status' => 422]);

            $datas = [];
            for ($i = 0; $i < 10; $i++) {
                $data = [];
                $data['quizId'] = $ans['quizId'];
                $data['description'] = $ans['question'][$i]['question'];
                $data['choices'] = implode(",", $ans['question'][$i]['answers']);
                $data['correct_answer'] = $ans['question'][$i]['correct_answer'];
                
                $userChoice = $ans['choices'][$i];
                if ($userChoice) $userChoice = ord($userChoice) - ord('a');
                $data['userChoice'] = $ans['question'][$i]['answers'][intval($userChoice)];

                $data['status'] = ($data['userChoice'] == $data['correct_answer']);

                array_push($datas, $data);
            }

            Answer::insert($datas);
            $result = Answer::where('quizId', $data['quizId'])->get();

            return $result;
        } catch (Error $err) {
            return $err;
        }
    }
}