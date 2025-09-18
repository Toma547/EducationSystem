@extends('admin.layouts.app')
@section('title', 'トップページ')

@section('content')
    <div class="top__user">
        <p>ユーザーネーム：　{{ $admin->name }}</p>
        <p>メールアドレス：　{{ $admin->email }}</p>
    </div>
@endsection
