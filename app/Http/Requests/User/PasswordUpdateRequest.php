<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class PasswordUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'current_password' => ['required', 'current_password'],
            'password' => ['required','confirmed','min:8','string'],
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => '現在設定されているパスワードを入力してください',
            'current_password.current_password' => '現在設定されているパスワードと一致しません',
            'password.required' => '新パスワードは入力必須項目です',
            'password.min' => '新パスワードは8文字以上で入力してください',
            'password.confirmed' => '新パスワードと一致しません',
        ];
    }
}
