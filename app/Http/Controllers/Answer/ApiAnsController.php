<?php

namespace App\Http\Controllers\Answer;

use App\Http\Controllers\Controller;
use App\Services\AnsService;
use Error;
use Illuminate\Http\Request;

class ApiAnsController extends Controller
{
    private AnsService $ansService;

    public function __construct(AnsService $ansService)
    {
        $this->ansService = $ansService;
    }

    public function getAllAnsByQuizId($id) {
        try {
            $response = $this->ansService->getAllAnsByQuizId($id);

            return response($response, $response['status'] ?? 200);
        } catch (Error $err) {
            return response(['Message' => 'Internal Server Error'], 500);
        }
    }
}
