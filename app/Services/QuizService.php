<?php

namespace App\Services;

interface QuizService
{
    public function getAllQuizByUser($userId);
    public function getQuizById($id);
    public function addQuiz($data);
}