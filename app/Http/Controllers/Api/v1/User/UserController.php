<?php

namespace App\Http\Controllers\Api\v1\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Response\Api\v1\ApiResponse;
use App\Http\Requests\Api\v1\User\UserRequest;
use App\Interface\Api\v1\User\UserServiceInterface as Service;

class UserController extends Controller
{
    public function __construct(public Service $service)
    {
    }

    public function index(Request $request): ApiResponse
    {
        return $this->service->index($request);
    }

    public function store(UserRequest $request): ApiResponse
    {
        return $this->service->store($request);
    }

    public function show(string $id): ApiResponse
    {
        return $this->service->show($id);
    }

    public function update(string $id, UserRequest $request): ApiResponse
    {
        return $this->service->update($id, $request);
    }

    public function destroy(string $id): ApiResponse
    {
        return $this->service->destroy($id);
    }
}