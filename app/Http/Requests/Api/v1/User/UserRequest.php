<?php

namespace App\Http\Requests\Api\v1\User;

use App\Http\Requests\Api\v1\Base\BaseFormRequest;

class UserRequest extends BaseFormRequest
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
        return request()->method() == 'POST' ? $this->createUserRules() : $this->UpdateUserRules();
    }

    public function createUserRules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:5', 'max:50'],
            'avatar' => ['nullable', 'image', 'max:2048']
        ];
    }

    public function UpdateUserRules(): array
    {
        return [
            'name' => ['nullable', 'string', 'min:2', 'max:255'],
            'email' => ['nullable', 'email', 'unique:users,email,'. $this->route('user')],
            'password' => ['nullable', 'string', 'min:5', 'max:50'],
            'is_active' => ['nullable', 'boolean'],
            'avatar' => ['nullable', 'image','max:2048']
        ];
    }
}
