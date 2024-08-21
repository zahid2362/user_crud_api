<?php

namespace App\Interface\Api\v1\Auth;

use App\Http\Requests\Api\v1\Auth\LoginRequest;

interface AuthServiceInterface
{
    public function login(LoginRequest $request): array;
    // public function registration(Request $request): ApiResponse;
}
