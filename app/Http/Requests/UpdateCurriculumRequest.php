<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCurriculumRequest extends FormRequest
{
    public function authorize()
    {
        return true; // 認可OK
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'thumbnail' => 'nullable|string|max:255', // ✅ 空OK
            'description' => 'nullable|string',        // ✅ 空OK
            'video_url' => 'nullable|string|max:255',  // ✅ URLじゃなく文字列でOK（空OK）
            'grade_id' => 'required|integer|exists:grades,id',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'タイトルは必須です。',
            'grade_id.required' => '学年を選択してください。',
            'grade_id.exists' => '選択された学年が無効です。',
        ];
    }
}
