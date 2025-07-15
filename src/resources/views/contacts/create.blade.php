@extends('layouts.app')

@section('page-title')
<div class="page-title">Contact</div>
@endsection

@section('content')
<div class="contact-page">
    <form class="contact-form" action="{{ route('contacts.confirm') }}" method="POST">
        @csrf

        {{-- お名前（姓・名） --}}
        <div class="form-row">
            <label>お名前 ※</label>
            <div class="form-input-double">
                <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="例: 山田">
                <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="例: 太郎">
            </div>
        </div>
        @error('last_name') <div class="error">{{ $message }}</div> @enderror
        @error('first_name') <div class="error">{{ $message }}</div> @enderror

        {{-- 性別 --}}
        <div class="form-row">
            <label>性別 ※</label>
            <div>
                <input type="radio" name="gender" value="男性" {{ old('gender', '男性') == '男性' ? 'checked' : '' }}> 男性
                <input type="radio" name="gender" value="女性" {{ old('gender') == '女性' ? 'checked' : '' }}> 女性
                <input type="radio" name="gender" value="その他" {{ old('gender') == 'その他' ? 'checked' : '' }}> その他
            </div>
        </div>
        @error('gender') <div class="error">{{ $message }}</div> @enderror

        {{-- メールアドレス --}}
        <div class="form-row">
            <label>メールアドレス ※</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="例: test@example.com">
        </div>
        @error('email') <div class="error">{{ $message }}</div> @enderror

        {{-- 電話番号 --}}
        <div class="form-row">
            <label>電話番号 ※</label>
            <input type="text" name="tel" value="{{ old('tel') }}" placeholder="08012345678">
        </div>
        @error('tel') <div class="error">{{ $message }}</div> @enderror

        {{-- 住所 --}}
        <div class="form-row">
            <label>住所 ※</label>
            <input type="text" name="address" value="{{ old('address') }}" placeholder="例: 東京都渋谷区千駄ヶ谷1-2-3">
        </div>
        @error('address') <div class="error">{{ $message }}</div> @enderror

        {{-- 建物名 --}}
        <div class="form-row">
            <label>建物名</label>
            <input type="text" name="building" value="{{ old('building') }}" placeholder="例: 千駄ヶ谷マンション101">
        </div>

        {{-- お問い合わせの種類 --}}
        <div class="form-row">
            <label>お問い合わせの種類 ※</label>
            <select name="category_id">
                <option value="">選択してください</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>
        @error('category_id') <div class="error">{{ $message }}</div> @enderror

        {{-- お問い合わせ内容 --}}
        <div class="form-row">
            <label>お問い合わせ内容 ※</label>
            <textarea name="content" rows="5" placeholder="お問い合わせ内容をご記載ください">{{ old('content') }}</textarea>
        </div>
        @error('content') <div class="error">{{ $message }}</div> @enderror

        {{-- 確認画面ボタン --}}
        <div class="form-row" style="justify-content:center;">
            <button type="submit" class="contact-btn">確認画面</button>
        </div>
    </form>
</div>
@endsection