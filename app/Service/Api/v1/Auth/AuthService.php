<?php

namespace App\Service\Api\v1\Auth;

use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Api\v1\Auth\LoginRequest;
use App\Interface\Api\v1\Auth\AuthServiceInterface;

class AuthService implements AuthServiceInterface
{
    public const LOG_CHANNEL = 'auth_service';

    public function login(LoginRequest $request): array
    {
        try {
            $data = $request->validated();

            if (auth('web')->attempt($data)) {
                return successResponse($this->loginData());
            } else {
                return errorResponse(__('auth.failed'), Response::HTTP_UNAUTHORIZED);
            }
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


    /**
     * @param $email
     * @param null $remember
     * @param null $message
     * @return array
     */
    private function loginData($message = null): array
    {
        $user = auth('web')->user();
        return [
            'profile' => $user,
            'token' => $this->generateAuthToken($user),
        ];
    }

    /**
    * @param $user
    * @return mixed
    */
    private function generateAuthToken($user): mixed
    {
        return $user->createToken('token')->plainTextToken;
    }
}
