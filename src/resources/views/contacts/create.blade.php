@extends('layouts.app')

@section('content')

<h2>Contact</h2>

<form action="{{ route('contacts.confirm') }}" method="POST">
    @csrf

    {{-- お名前（姓・名） --}}
    <div>
        <label>お名前 ※</label>
        <div>
            <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="例: 山田">
            <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="例: 太郎">
        </div>
        @error('last_name')
        <div>{{ $message }}</div>
        @enderror
        @error('first_name')
        <div>{{ $message }}</div>
        @enderror
    </div>

    {{-- 性別 --}}
    <div>
        <label>性別 ※</label>
        <div>
            <input type="radio" name="gender" value="男性" {{ old('gender', '男性') == '男性' ? 'checked' : '' }}> 男性
            <input type="radio" name="gender" value="女性" {{ old('gender') == '女性' ? 'checked' : '' }}> 女性
            <input type="radio" name="gender" value="その他" {{ old('gender') == 'その他' ? 'checked' : '' }}> その他
        </div>
        @error('gender')
        <div>{{ $message }}</div>
        @enderror
    </div>

    {{-- メールアドレス --}}
    <div>
        <label>メールアドレス ※</label>
        <input type="email" name="email" value="{{ old('email') }}" placeholder="例: test@example.com">
        @error('email')
        <div>{{ $message }}</div>
        @enderror
    </div>

    {{-- 電話番号 --}}
    <div>
        <label>電話番号 ※</label>
        <input type="text" name="tel" value="{{ old('tel') }}" placeholder="08012345678">
        @error('tel')
        <div>{{ $message }}</div>
        @enderror
    </div>

    {{-- 住所 --}}
    <div>
        <label>住所 ※</label>
        <input type="text" name="address" value="{{ old('address') }}" placeholder="例: 東京都渋谷区千駄ヶ谷1-2-3">
        @error('address')
        <div>{{ $message }}</div>
        @enderror
    </div>

    {{-- 建物名 --}}
    <div>
        <label>建物名</label>
        <input type="text" name="building" value="{{ old('building') }}" placeholder="例: 千駄ヶ谷マンション101">
    </div>

    {{-- お問い合わせの種類 --}}
    <div>
        <label>お問い合わせの種類 ※</label>
        <select name="category_id">
            <option value="">選択してください</option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
            @endforeach
        </select>
        @error('category_id')
        <div>{{ $message }}</div>
        @enderror
    </div>

    {{-- お問い合わせ内容 --}}
    <div>
        <label>お問い合わせ内容 ※</label>
        <textarea name="content" rows="5" placeholder="お問い合わせ内容をご記載ください">{{ old('content') }}</textarea>
        @error('content')
        <div>{{ $message }}</div>
        @enderror
    </div>

    {{-- 確認画面ボタン --}}
    <div>
        <button type="submit">確認画面</button>
    </div>
</form>
@endsection