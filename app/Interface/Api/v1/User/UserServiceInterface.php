<?php

namespace App\Interface\Api\v1\User;

use Illuminate\Http\Request;
use App\Http\Requests\Api\v1\User\UserRequest;

interface UserServiceInterface
{
    public function index(Request $request): array;
    public function store(UserRequest $request): array;
    public function show(string $id): array;
    public function update(string $id, UserRequest $request): array;
    public function destroy(string $id): array;
}
