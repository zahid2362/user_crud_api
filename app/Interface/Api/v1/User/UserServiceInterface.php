<?php

namespace App\Interface\Api\v1\User;

use Illuminate\Http\Request;
use App\Http\Requests\Api\v1\User\UserRequest;
use App\Response\Api\v1\ApiResponse;

interface UserServiceInterface
{
    public function index(Request $request): ApiResponse;
    public function store(UserRequest $request): ApiResponse;
    public function show(string $id): ApiResponse;
    public function update(string $id, UserRequest $request): ApiResponse;
    public function destroy(string $id): ApiResponse;
}