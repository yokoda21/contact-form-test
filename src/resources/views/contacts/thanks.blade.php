@extends('layouts.app')

@section('content')
<h1>お問い合わせありがとうございました</h1>
<form action="{{ route('contacts.create') }}" method="get">
    <button type="submit">HOME</button>
</form>
@endsection