<?php

namespace App\Service\Api\v1\User;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Response\Api\v1\ApiResponse;
use App\Http\Requests\Api\v1\User\UserRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Interface\Api\v1\User\UserServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserService implements UserServiceInterface
{
    public const LOG_CHANNEL = 'user_service';

    public function __construct(public ApiResponse $response)
    {
    }

    /**
     * @param Request $request
     * @return ApiResponse
    */
    public function index(Request $request): ApiResponse
    {
        try {
            $users = User::paginate($request->per_page ?? 10);
            return $this->response->success($users);
        } catch (Exception $ex) {
            Log::channel(self::LOG_CHANNEL)->error($ex->getMessage());
            return $this->response->failed(__('message.error'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param UserRequest $request
     * @return ApiResponse
    */
    public function store(UserRequest $request): ApiResponse
    {
        try {
            $data = $request->validated();

            if(!empty($data['avatar'])) {
                $fileName = date('ymdhis') . '-' . rand(1111, 9999);
                $data['avatar'] =  fileUpload(User::AVATAR_PATH, $fileName, $data['avatar']);
            }

            $user = User::create($data);
            return $this->response->success(['data' => $user], __('message.user.create'));
        } catch (Exception $ex) {
            Log::channel(self::LOG_CHANNEL)->error($ex->getMessage());
            return $this->response->failed(__('message.error'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param string $id
     * @return ApiResponse
     */
    public function show(string $id): ApiResponse
    {
        try {
            $user = User::findOrFail($id);
            return $this->response->success(['data' => $user]);
        } catch(ModelNotFoundException $ex) {
            Log::channel(self::LOG_CHANNEL)->error($ex->getMessage());
            return $this->response->failed(__('message.user.not.found'), Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            Log::channel(self::LOG_CHANNEL)->error($ex->getMessage());
            return $this->response->failed(__('message.error'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param string $id
     * @param UserRequest $request
     * @return ApiResponse
     */
    public function update(string $id, UserRequest $request): ApiResponse
    {
        try {
            $user = User::findOrFail($id);
            $data = $request->validated();

            if(!empty($data['avatar'])) {
                $fileName = date('ymdhis') . '-' . rand(1111, 9999);
                $data['avatar'] =  fileUpload(User::AVATAR_PATH, $fileName, $data['avatar'], $user->avatar);
            }

            $user->update($data);

            return $this->response->success(['data' => $user], __('message.user.update'));

        } catch(ModelNotFoundException $ex) {
            Log::channel(self::LOG_CHANNEL)->error($ex->getMessage());
            return $this->response->failed(__('message.user.not.found'), Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            Log::channel(self::LOG_CHANNEL)->error($ex->getMessage());
            return $this->response->failed(__('message.error'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param string $id
     * @return ApiResponse
     */
    public function destroy(string $id): ApiResponse
    {
        try {
            $user = User::destroy($id);
            return !empty($user) ? $this->response->success(message:__('message.user.update')) : $this->response->failed(__('message.user.not.found'), Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            Log::channel(self::LOG_CHANNEL)->error($ex->getMessage());
            return $this->response->failed(__('message.error'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /*
    |
    |--------------------------------------------------------------------------
    | class internal methods
    |--------------------------------------------------------------------------
    |
    */
}
