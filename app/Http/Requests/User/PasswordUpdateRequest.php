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
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ];
    }

    public function messages()
    {
        return [
            'current_password.required' => '現在設定されているパスワードを入力してください',
            'password.required' => '新パスワードは入力必須項目です',
            'password.min' => '新パスワードは8文字以上で入力してください',
            'password.confirmed' => '新パスワードと一致しません',
        ];
    }
}
