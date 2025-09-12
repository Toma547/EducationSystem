@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6">
    <a href="javascript:history.back()" class="text-gray-700 font-semibold hover:underline">&larr; 戻る</a>

    <h2 class="text-3xl font-bold mb-6">プロフィール変更</h2>

    @if(session('status'))
        <div class="bg-green-200 text-green-800 p-3 rounded mb-4">{{ session('status') }}</div>
    @endif

    <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PATCH')

        <div>
            <label class="block mb-2">プロフィール画像</label>
            <div class="flex items-center space-x-4">
                {{-- 画像アイコン（アップロード済み or Noimage） --}}
                @if($user->profile_image)
                {{-- 登録済み画像を表示 --}}
                <img src="{{ asset('storage/'.$user->profile_image) }}"
                alt="プロフィール画像"
                class="w-20 h-20 rounded-full object-cover border-2 border-gray-300">
            @else
                {{-- Noimage画像を表示 --}}
                <div class="w-20 h-20 flex items-center justify-center bg-gray-200 rounded-full text-gray-500 border-2 border-gray-300">
                    Noimage
                </div>
            @endif

            {{-- ファイル選択ボタン --}}
            <input type="file" name="profile_image" class="border p-2">
            </div>
        </div>

        <div>
            <label class="block mb-2">ユーザーネーム</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="border p-2 w-full">
        </div>

        <div>
            <label class="block mb-2">カナ</label>
            <input type="text" name="name_kana" value="{{ old('name_kana', $user->name_kana) }}" class="border p-2 w-full">
        </div>

        <div>
            <label class="block mb-2">メールアドレス</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="border p-2 w-full">
        </div>

        <div>
            <button type="button" onclick="location.href='{{ route('user.password.edit') }}'"
                class="bg-gray-200 px-3 py-1">パスワードを変更する</button>
        </div>

        <button type="submit" class="bg-orange-500 text-white px-5 py-2">登録</button>
    </form>
</div>
@endsection
