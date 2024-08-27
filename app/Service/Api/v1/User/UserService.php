<?php

namespace App\Service\Api\v1\User;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Api\v1\User\UserRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Interface\Api\v1\User\UserServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserService implements UserServiceInterface
{
    public const LOG_CHANNEL = 'user_service';

    /**
     * @param Request $request
     * @return array
    */
    public function index(Request $request): array
    {
        try {
            $users = User::paginate($request->per_page ?? 10);
            return successResponse(['user' => $users]);
        } catch (Exception $ex) {
            Log::channel(self::LOG_CHANNEL)->error($ex->getMessage());
            return errorResponse(__('message.error'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param UserRequest $request
     * @return array
    */
    public function store(UserRequest $request): array
    {
        try {
            $data = $request->validated();

            if(!empty($data['avatar'])) {
                $fileName = date('ymdhis') . '-' . rand(1111, 9999);
                $data['avatar'] =  fileUpload(User::AVATAR_PATH, $fileName, $data['avatar']);
            }

            $user = User::create($data);
            return successResponse(['user' => $user , 'message' => __('message.user.create')]);
        } catch (Exception $ex) {
            Log::channel(self::LOG_CHANNEL)->error($ex->getMessage());
            return errorResponse(__('message.error'));
        }
    }

    /**
     * @param string $id
     * @return array
     */
    public function show(string $id): array
    {
        try {
            $user = User::findOrFail($id);

            return successResponse(['user' => $user]);
        } catch(ModelNotFoundException $ex) {
            Log::channel(self::LOG_CHANNEL)->error($ex->getMessage());
            return errorResponse(__('message.user.not.found'), Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            Log::channel(self::LOG_CHANNEL)->error($ex->getMessage());
            return errorResponse(__('message.error'));
        }
    }

    /**
     * @param string $id
     * @param UserRequest $request
     * @return array
     */
    public function update(string $id, UserRequest $request): array
    {
        try {
            $user = User::findOrFail($id);
            $data = $request->validated();

            if(!empty($data['avatar'])) {
                $fileName = date('ymdhis') . '-' . rand(1111, 9999);
                $data['avatar'] =  fileUpload(User::AVATAR_PATH, $fileName, $data['avatar'], $user->avatar);
            }

            $user->update($data);

            $data = [
                'user' => $user,
                'message' => __('message.user.update'),
            ];

            return successResponse($data);

        } catch(ModelNotFoundException $ex) {
            Log::channel(self::LOG_CHANNEL)->error($ex->getMessage());
            return errorResponse(__('message.user.not.found'), Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            Log::channel(self::LOG_CHANNEL)->error($ex->getMessage());
            return errorResponse(__('message.error'));
        }
    }

    /**
     * @param string $id
     * @return array
     */
    public function destroy(string $id): array
    {
        try {
            $user = User::destroy($id);
            return !empty($user) ? successResponse(['message' => __('message.user.deleted')]) :
             errorResponse(__('message.user.not.found'), Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            Log::channel(self::LOG_CHANNEL)->error($ex->getMessage());
            return errorResponse(__('message.error'));
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
