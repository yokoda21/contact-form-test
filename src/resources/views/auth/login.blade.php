@extends('layouts.app')

@section('content')
<div class="login-page">
    <div class="login-title">Login</div>
    <form action="/login" method="POST" autocomplete="off">
        @csrf

        <label for="email">メールアドレス</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="例: test@example.com" required>
        @error('email')
        <div class="error">{{ $message }}</div>
        @enderror

        <label for="password">パスワード</label>
        <input type="password" id="password" name="password" placeholder="例: coachtech1106" required>
        @error('password')
        <div class="error">{{ $message }}</div>
        @enderror

        <button type="submit" class="login-btn">ログイン</button>
    </form>
    <div class="register-link">
        <a href="/register">会員登録の方はこちら</a>
    </div>
</div>
@endsection