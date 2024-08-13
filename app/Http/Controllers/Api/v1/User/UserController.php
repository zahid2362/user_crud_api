<?php

namespace App\Http\Controllers\Api\v1\User;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\User\UserRequest;
use App\Interface\Api\v1\User\UserServiceInterface;

class UserController extends Controller
{
    public function __construct(public UserServiceInterface $service)
    {
    }

    public function index(Request $request)
    {
        $data = $this->service->index($request);
        return response()->json(Arr::except($data, ['status']), $data['status'] ?? 200);
    }

    public function store(UserRequest $request)
    {
        $data = $this->service->store($request);
        return response()->json(Arr::except($data, ['status']), $data['status'] ?? 200);
    }

    public function show(string $id)
    {
        $data = $this->service->show($id);
        return response()->json(Arr::except($data, ['status']), $data['status'] ?? 200);
    }

    public function update(string $id, UserRequest $request)
    {
        $data = $this->service->update($id, $request);
        return response()->json(Arr::except($data, ['status']), $data['status'] ?? 200);
    }

    public function destroy(string $id)
    {
        $data = $this->service->destroy($id);
        return response()->json(Arr::except($data, ['status']), $data['status'] ?? 200);
    }
}
