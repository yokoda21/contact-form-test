@extends('layouts.app')

@section('content')
<div class="register-page">
    <header class="register-header">
        <span class="site-title">FashionablyLate</span>
        <a href="{{ url('/login') }}">
            <button class="header-login-btn">login</button>
        </a>
    </header>
    <div class="register-box">
        <div class="register-title">Register</div>
        <form action="{{ url('/register') }}" method="POST" autocomplete="off">
            @csrf

            <label for="name">お名前</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="例: 山田 太郎" required>
            @error('name')
            <div class="error">{{ $message }}</div>
            @enderror

            <label for="email">メールアドレス</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="例: test@example.com" required>
            @error('email')
            <div class="error">{{ $message }}</div>
            @enderror

            <label for="password">パスワード</label>
            <input type="password" id="password" name="password" placeholder="※ 8文字以上" required>
            @error('password')
            <div class="error">{{ $message }}</div>
            @enderror
            <label for="password_confirmation">パスワード確認</label>
            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="もう一度入力" required>
            @error('password_confirmation')
            <div class="error">{{ $message }}</div>
            @enderror

            <button type="submit" class="register-btn">登録</button>
        </form>
    </div>
</div>
@endsection