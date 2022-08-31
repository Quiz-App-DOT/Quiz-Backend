<?php

namespace App\Services;

interface AnsService
{
    public function getAllAnsByQuizId($id);
    public function addOneAns($ans);
    public function addManyAns($ans);
}