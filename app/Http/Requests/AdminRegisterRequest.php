<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRegisterRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'kana' => ['required', 'string', 'max:255', 'regex:/^[ァ-ヶー　]+$/u'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'ユーザーネームは必須項目です',
            'kana.required' => 'カナは必須項目です',
            'kana.regex' => 'カナはカタカナで入力してください',
            'email.required' => 'メールアドレスは必須項目です',
            'email.email' => 'メールアドレス形式で入力してください',
            'email.unique' => 'このメールアドレスはすでに使用されています',
            'password.required' => 'パスワードは必須項目です',
            'password.min' => 'パスワードは8文字以上で入力してください',
            'password_confirmation.required' => '確認用パスワードは必須項目です',
            'password.confirmed' => '確認用パスワードが一致しません',
        ];
    }
}
