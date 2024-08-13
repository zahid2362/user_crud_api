<?php

namespace App\Service\Api\v1\User;

use App\Http\Requests\Api\v1\User\UserRequest;
use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Interface\Api\v1\User\UserServiceInterface;

class UserService implements UserServiceInterface
{
    /**
     * @param Request $request
     * @return array<string, mixed>
    */
    public function index(Request $request): array
    {
        try {
            return [
                'success' => true,
                'data' => User::all()
            ];
        } catch (Exception $ex) {
            Log::channel('user_service')->error($ex->getMessage());
            return $this->error(__('message.error'));
        }
    }

    /**
     * @param UserRequest $request
     * @return array<string, mixed>
    */
    public function store(UserRequest $request): array
    {
        try {
            $data = $request->validated();
            if(!empty($data['avatar'])) {
                $data['avatar'] =  $this->storeAvatar($data['avatar']);
            }
            $user = User::create($data);
            return [
                'success' => true,
                'message' => __('message.user.create'),
                'data' => $user
            ];
        } catch (Exception $ex) {
            Log::channel('user_service')->error($ex->getMessage());
            return $this->error(__('message.error'));
        }
    }

    /**
     * @param string $id
     * @return array<string, mixed>
     */
    public function show(string $id): array
    {
        try {
            $user = User::find($id);

            return !empty($user) ? [
                'success' => true,
                'data' => $user
            ] : $this->error(__('message.user.not.found'), 404);

        } catch (Exception $ex) {
            Log::channel('user_service')->error($ex->getMessage());
            return $this->error(__('message.error'));
        }
    }

    /**
     * @param string $id
     * @param UserRequest $request
     * @return array<string, mixed>
     */
    public function update(string $id, UserRequest $request): array
    {
        try {
            $data = $request->validated();
            $user = User::find($id);
            if(empty($user)) {
                return $this->error(__('message.user.not.found'), 404);
            }

            if(!empty($data['avatar'])) {
                $data['avatar'] =  $this->storeAvatar($data['avatar'], $user->avatar);
            }

            $user->update($data);

            return [
                'success' => true,
                'message' => __('message.user.update'),
                'data' => $user
            ];

        } catch (Exception $ex) {
            Log::channel('user_service')->error($ex->getMessage());
            return $this->error(__('message.error'));
        }
    }

    /**
     * @param string $id
     * @return array<string, mixed>
     */
    public function destroy(string $id): array
    {
        try {
            $user = User::destroy($id);

            return !empty($user) ? [
                'success' => true,
                'message' => __('message.user.deleted')
            ] : $this->error(__('message.user.not.found'), 404);
        } catch (Exception $ex) {
            Log::channel('user_service')->error($ex->getMessage());
            return $this->error(__('message.error'));
        }
    }

    /**
     * @param mixed $file
     * @param ?string $avatar
     * @return string|bool
     */
    public function storeAvatar(mixed $file, ?string $avatar = null): string|bool
    {
        if (!empty($avatar) && Storage::exists($avatar)) {
            Storage::delete($avatar);
        }

        $file_name = date('ymdhis') . '-' . rand(1111, 9999) . '.' . $file->getClientOriginalExtension();
        return Storage::putFileAs(User::AVATAR_PATH, $file, $file_name);
    }

    /**
     * @param string $message
     * @param int $status
     * @return array<string, mixed>
     */
    public function error(string $message = '', int $status = 500): array
    {
        return [
            'success' => false,
            'message' => $message,
            'status' => $status,
            'data' => []
        ];
    }
}
