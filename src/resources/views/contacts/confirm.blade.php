@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center">FashionablyLate</h1>
    <h2 class="text-center">Confirm</h2>

    <table>
        <tr>
            <th>お名前</th>
            <td>{{ $inputs['last_name'] ?? '' }}　{{ $inputs['first_name'] ?? '' }}</td>
        </tr>
        <tr>
            <th>性別</th>
            <td>{{ $inputs['gender'] ?? '' }}</td>
        </tr>
        <tr>
            <th>メールアドレス</th>
            <td>{{ $inputs['email'] ?? '' }}</td>
        </tr>
        <tr>
            <th>電話番号</th>
            <td>{{ $inputs['tel'] ?? '' }}</td>
        </tr>
        <tr>
            <th>住所</th>
            <td>{{ $inputs['address'] ?? '' }}</td>
        </tr>
        <tr>
            <th>建物名</th>
            <td>{{ $inputs['building'] ?? '' }}</td>
        </tr>
        <tr>
            <th>お問い合わせの種類</th>
            <td>{{ $categoryName }}</td>
        </tr>
        <tr>
            <th>お問い合わせ内容</th>
            <td>{!! nl2br(e($inputs['content'] ?? '')) !!}</td>
        </tr>
    </table>

    {{-- 送信ボタンのフォーム --}}
    <form action="{{ route('contacts.store') }}" method="POST" style="display:inline;">
        @csrf
        @foreach ($inputs as $name => $value)
        <input type="hidden" name="{{ $name }}" value="{{ $value }}">
        @endforeach
        <button type="submit">送信</button>
    </form>

    {{-- 修正ボタンのフォーム --}}
    <form action="{{ route('contacts.back') }}" method="POST" style="display:inline;">
        @csrf
        @foreach ($inputs as $name => $value)
        <input type="hidden" name="{{ $name }}" value="{{ $value }}">
        @endforeach
        <button type="submit">修正</button>
    </form>
</div>
@endsection