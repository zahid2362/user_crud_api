<?php

namespace App\Http\Requests\Api\v1\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return request()->routeIs('user.create') ? $this->createUserRules() : $this->UpdateUserRules();
    }

    public function createUserRules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:5', 'max:50'],
            'avatar' => ['nullable', 'image','max:2048']
        ];
    }

    public function UpdateUserRules(): array
    {
        return [
            'name' => ['nullable', 'string', 'min:2', 'max:255'],
            'email' => ['nullable', 'email', 'unique:users,email,'.$this->route('user')],
            'password' => ['nullable', 'string', 'min:5', 'max:50'],
            'is_active' => ['nullable', 'boolean'],
            'avatar' => ['nullable', 'image','max:2048']
        ];
    }

     
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }

}