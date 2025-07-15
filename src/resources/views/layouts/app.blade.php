<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'FashionablyLate')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inika:wght@400;700&display=swap" rel="stylesheet">
    {{-- 共通CSS --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <header>
        <div class="header">
            <span class="header-title">FashionablyLate</span>
            {{-- 管理画面のみ右上にログアウト --}}
            @auth
            @if (Request::is('admin*'))
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="header-link" style="border:none; background:none; color:#b4a191; font-size:16px; margin-left:16px;">logout</button>
            </form>
            @elseif (Request::is('register'))
            <a href="{{ url('/login') }}" class="header-link">login</a>
            @elseif (Request::is('login'))
            <a href="{{ url('/register') }}" class="header-link">register</a>
            @endif
            @else
            @if (Request::is('register'))
            <a href="{{ url('/login') }}" class="header-link">login</a>
            @elseif (Request::is('login'))
            <a href="{{ url('/register') }}" class="header-link">register</a>
            @endif
            @endauth
        </div>
        @yield('page-title')
        @yield('header')
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        {{-- フッター --}}
    </footer>
    @yield('scripts')
</body>

</html>