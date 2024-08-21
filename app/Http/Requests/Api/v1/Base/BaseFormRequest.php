<?php

namespace App\Http\Requests\Api\v1\Base;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseFormRequest extends FormRequest
{
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => __('message.error'),
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }

    protected function failedAuthorization()
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => __('auth.unauthenticated')
            ], Response::HTTP_UNAUTHORIZED)
        );
    }
}
