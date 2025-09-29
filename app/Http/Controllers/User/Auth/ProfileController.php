<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Http\Requests\User\ProfileUpdateRequest;
use App\Http\Requests\User\PasswordUpdateRequest;
use Symfony\Component\HttpKernel\Profiler\Profile;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

    // プロフィール編集画面
    public function edit()
    {
        $user = Auth::user();
        return view('user.layouts.profile_edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    
     // プロフィール更新処理
    public function update(ProfileUpdateRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // バリデーション済みデータを取得
        $validated = $request->validated();

        $user->updateProfile($validated, $request->file('profile_image'));

        return redirect()->route('user.profile.edit')->with('status', 'プロフィールを更新しました');
    }

    /**
     * Delete the user's account.
     */

    // パスワード変更画面 
    public function editPassword()
    {
        return view('user.layouts.password_edit');
    }

    // パスワード更新処理
    public function updatePassword(PasswordUpdateRequest $request)
    {
        /** @var \App\Models\User $user */
       $user = Auth::user();

        // 現在のパスワードチェック
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => '現在のパスワードが正しくありません']);
        }

        // モデルに切り出した更新処理を呼び出し
        $user->updatePassword($request->password);

        return redirect()->route('user.profile.edit')->with('status', 'パスワードを変更しました');
    }
}

