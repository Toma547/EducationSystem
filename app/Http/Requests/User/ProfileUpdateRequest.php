<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'name_kana' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore(Auth::id())
            ],
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'ユーザーネームは入力必須項目です',
            'name_kana.required' => 'カナは入力必須項目です',
            'email.required' => 'メールアドレスは入力必須です',
        ];
    }
}
