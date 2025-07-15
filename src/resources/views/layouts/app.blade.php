<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'FashionablyLate')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- 共通CSSをここで読み込み --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <header>
        {{-- ヘッダー（例：サイト名やメニューなど） --}}
        <h1>FashionablyLate</h1>
        
        @auth
        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button type="submit">ログアウト</button>
        </form>
        @endauth

        @yield('header')
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        {{-- フッター --}}
    </footer>
</body>

</html>