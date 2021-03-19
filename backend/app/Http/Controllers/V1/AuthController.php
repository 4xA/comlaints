<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function login(Request $request)
    {
        $result = ['status' => 200];

        try {
            $result['data'] = [
                'api_token' => $this->userService->issueApiToken($request->all())
            ];
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
