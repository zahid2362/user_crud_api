<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Auth\LoginRequest;
use App\Interface\Api\v1\Auth\AuthServiceInterface as Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(public Service $service)
    {
    }
    public function login(LoginRequest $request): JsonResponse
    {
        $response = $this->service->login($request);
        return response()->json($response['data'], $response['status']);
    }

    public function profile(Request $request)
    {
        return response()->json($request->user() ?? []);
    }

}
