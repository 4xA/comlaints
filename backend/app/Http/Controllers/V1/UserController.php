<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function store(Request $request)
    {
        $result = ['status' => 201];

        try {
            $result['data'] = $this->userService->saveUserData($request->all());
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
