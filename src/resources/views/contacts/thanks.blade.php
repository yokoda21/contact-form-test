@extends('layouts.app')

@section('content')
<div class="thanks-wrap">
    <div class="thanks-bg-text">Thank you</div>
    <div class="thanks-content-box">
        <div class="thanks-message">お問い合わせありがとうございました</div>
        <a href="{{ route('contacts.create') }}" class="thanks-home-btn">HOME</a>
    </div>
</div>
@endsection