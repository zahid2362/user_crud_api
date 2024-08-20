<?php

namespace App\Response\Api\v1;

use Illuminate\Http\JsonResponse;

class ApiResponse extends JsonResponse
{
    /**
    * Return a successful JSON response.
    *
    * @param mixed $data
    * @param int $status
    * @param array $headers
    * @param int $options
    * @return static
    */
    public static function success(mixed $data = null, string $message = "", int $status = 200, array $headers = [], int $options = 0)
    {
        $responseData['success'] = true;

        if(!empty($message)) {
            $responseData['message'] = $message;
        }

        if(!empty($data)) {
            $responseData['data'] = $data;
        }

        return new static($responseData, $status, $headers, $options);
    }

    /**
     * Return a failed JSON response.
     *
     * @param string $message
     * @param int $status
     * @param array $headers
     * @param int $options
     * @return static
     */
    public static function failed(string $message, int $status = 400, array $headers = [], int $options = 0)
    {
        $responseData = [
            'success' => false,
            'message' => $message,
        ];

        return new static($responseData, $status, $headers, $options);
    }
}
