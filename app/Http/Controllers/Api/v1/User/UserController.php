<?php

namespace App\Http\Controllers\Api\v1\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\User\UserRequest;
use App\Interface\Api\v1\User\UserServiceInterface as Service;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(public Service $service)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $response = $this->service->index($request);
        return response()->json($response['data'], $response['status']);
    }

    public function store(UserRequest $request): JsonResponse
    {
        $response = $this->service->store($request);
        return response()->json($response['data'], $response['status']);
    }

    public function show(string $id): JsonResponse
    {
        $response = $this->service->show($id);
        return response()->json($response['data'], $response['status']);
    }

    public function update(string $id, UserRequest $request): JsonResponse
    {
        $response = $this->service->update($id, $request);
        return response()->json($response['data'], $response['status']);
    }

    public function destroy(string $id): JsonResponse
    {
        $response = $this->service->destroy($id);
        return response()->json($response['data'], $response['status']);
    }
}
