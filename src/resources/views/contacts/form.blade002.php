@extends('layouts.app')

@section('content')
<div class="container">
    <h1>FashionablyLate</h1>
    <h2>お問い合わせフォーム</h2>
    <form action="{{ route('contacts.confirm') }}" method="POST">
        @csrf
        <div>
            <label>姓：</label>
            <input type="text" name="last_name" value="{{ old('last_name', $inputs['last_name'] ?? '') }}">
        </div>
        <div>
            <label>名：</label>
            <input type="text" name="first_name" value="{{ old('first_name', $inputs['first_name'] ?? '') }}">
        </div>
        <div>
            <label>性別：</label>
            <select name="gender">
                <option value="male" {{ old('gender', $inputs['gender'] ?? '') == 'male' ? 'selected' : '' }}>男性</option>
                <option value="female" {{ old('gender', $inputs['gender'] ?? '') == 'female' ? 'selected' : '' }}>女性</option>
                <option value="other" {{ old('gender', $inputs['gender'] ?? '') == 'other' ? 'selected' : '' }}>その他</option>
            </select>
        </div>
        <div>
            <label>メールアドレス：</label>
            <input type="email" name="email" value="{{ old('email', $inputs['email'] ?? '') }}">
        </div>
        <div>
            <label>電話番号：</label>
            <input type="text" name="tel" value="{{ old('tel', $inputs['tel'] ?? '') }}">
        </div>
        <div>
            <label>住所1：</label>
            <input type="text" name="address1" value="{{ old('address1', $inputs['address1'] ?? '') }}">
        </div>
        <div>
            <label>住所2：</label>
            <input type="text" name="address2" value="{{ old('address2', $inputs['address2'] ?? '') }}">
        </div>
        <div>
            <label>件名：</label>
            <input type="text" name="title" value="{{ old('title', $inputs['title'] ?? '') }}">
        </div>
        <div>
            <label>お問い合わせ内容：</label>
            <textarea name="detail">{{ old('detail', $inputs['detail'] ?? '') }}</textarea>
        </div>
        <button type="submit">確認画面へ</button>
    </form>
</div>
@endsection