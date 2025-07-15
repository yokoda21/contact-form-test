@extends('layouts.app')

@section('page-title')
<div class="page-title">Confirm</div>
@endsection

@section('content')
<div class="confirm-box">
    <table class="confirm-table">
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
            <td>{{ $categoryName ?? '' }}</td>
        </tr>
        <tr>
            <th>お問い合わせ内容</th>
            <td style="white-space: pre-line;">{{ $inputs['content'] ?? '' }}</td>
        </tr>
    </table>
    <form action="{{ route('contacts.store') }}" method="POST" style="display:inline;">
        @csrf
        {{-- hiddenで入力値を保持 --}}
        @foreach($inputs as $key => $value)
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
        <button type="submit" class="confirm-btn">送信</button>
    </form>
    <form action="{{ route('contacts.back') }}" method="POST" style="display:inline;">
        @csrf
        @foreach($inputs as $key => $value)
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
        <button type="submit" class="confirm-btn btn-secondary">修正</button>
    </form>
</div>
@endsection