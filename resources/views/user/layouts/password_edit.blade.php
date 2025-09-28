@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6">
    <a href="{{ route('user.profile.edit') }}" class="text-gray-700 font-semibold hover:underline">&larr; 戻る</a>

    <h2 class="text-3xl font-bold mb-6">パスワード変更</h2>

    @if(session('status'))
        <div class="bg-green-200 text-green-800 p-3 rounded mb-4">{{ session('status') }}</div>
    @endif

    <form action="{{ route('user.password.update') }}" method="POST" class="space-y-5">
        @csrf
        @method('PATCH')

        {{-- 旧パスワード --}}
        <div>
            <label class="block mb-2">旧パスワード</label>
            <input type="password" name="current_password" class="border p-2 w-full">

            @error('current_password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- 新パスワード --}}
        <div>
            <label class="block mb-2">新パスワード</label>
            <input type="password" name="password" class="border p-2 w-full">

            @error('password')
               <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        {{-- 新パスワード確認 --}}
        <div>
            <label class="block mb-2">新パスワード確認</label>
            <input type="password" name="password_confirmation" class="border p-2 w-full">

            @error('password_confirmation')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
            
            @if($errors->has('password') && $errors->first('password') === '新パスワードと一致しません')
               <p class="text-red-500 text-sm">新パスワードと一致しません</p>
            @endif
        </div>

        <button type="submit" class="bg-orange-500 text-white px-5 py-2">登録</button>
    </form>
</div>
@endsection
