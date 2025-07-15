@extends('layouts.app')
@section('content')

<head>
    <meta charset="UTF-8">
    <title>管理画面 | FashionablyLate</title>
</head>

<body>
    <h1>FashionablyLate</h1>
    <h2>Admin</h2>

    {{-- 検索フォーム --}}
    <form method="GET" action="{{ route('admin.contacts.index') }}">
        <input type="text" name="name" value="{{ request('name') }}" placeholder="名前やメールアドレスを入力してください">
        <select name="gender">
            <option value="">性別</option>
            <option value="all" {{ request('gender') == 'all' ? 'selected' : '' }}>全て</option>
            <option value="男性" {{ request('gender') == '男性' ? 'selected' : '' }}>男性</option>
            <option value="女性" {{ request('gender') == '女性' ? 'selected' : '' }}>女性</option>
            <option value="その他" {{ request('gender') == 'その他' ? 'selected' : '' }}>その他</option>
        </select>
        <select name="type">
            <option value="">お問い合わせの種類</option>
            <option value="商品のお問い合わせ" {{ request('type') == '商品のお問い合わせ' ? 'selected' : '' }}>商品のお問い合わせ</option>
            <option value="その他" {{ request('type') == 'その他' ? 'selected' : '' }}>その他</option>
            {{-- 必要に応じて種類を追加 --}}
        </select>
        <input type="date" name="date" value="{{ request('date') }}">
        <button type="submit">検索</button>
        <button type="button" onclick="location.href='{{ route("admin.contacts.index") }}'">リセット</button>



    </form>

    {{-- エクスポートボタン --}}
    <form method="GET" action="{{ route('admin.contacts.export') }}">
        {{-- 検索条件も引き継ぐ --}}
        <input type="hidden" name="name" value="{{ request('name') }}">
        <input type="hidden" name="gender" value="{{ request('gender') }}">
        <input type="hidden" name="type" value="{{ request('type') }}">
        <input type="hidden" name="date" value="{{ request('date') }}">
        <input type="hidden" name="email" value="{{ request('email') }}">
        <button type="submit">エクスポート</button>
    </form>

    {{-- ページネーション --}}
    <div>
        {{ $contacts->links() }}
    </div>

    {{-- 一覧テーブル --}}
    <table border="1">
        <thead>
            <tr>
                <th>お名前</th>
                <th>性別</th>
                <th>メールアドレス</th>
                <th>お問い合わせの種類</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contacts as $contact)
            <tr>
                <td>{{ $contact->last_name }} {{ $contact->first_name }}</td>
                <td>{{ $contact->gender }}</td>
                <td>{{ $contact->email }}</td>
                <td>{{ $contact->type }}</td>
                <td>
                    <button type="button" onclick="showDetail('{{ $contact->id }}')">詳細</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- モーダルウィンドウ（bodyの末尾でOK） -->
    <div id="modal" style="display:none; position:fixed; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.3); justify-content:center; align-items:center; z-index:10000;">
        <div id="modal-content" style="background:#fff; padding:24px; min-width:320px; border-radius:8px; position:relative;">
            <span id="close-modal" style="cursor:pointer; position:absolute; top:8px; right:16px; font-size:20px;">×</span>
            <div id="modal-body">
                <!-- 詳細内容をここに挿入 -->
            </div>
        </div>
    </div>

    <script>
        function showDetail(id) {
            fetch(`/admin/contacts/${id}`)
                .then(res => res.json())
                .then(data => {
                    let html = `
                <p>お名前：${data.last_name} ${data.first_name}</p>
                <p>性別：${data.gender}</p>
                <p>メールアドレス：${data.email}</p>
                <p>電話番号：${data.tel ?? ''}</p>
                <p>住所：${data.address ?? ''}</p>
                <p>建物名：${data.building ?? ''}</p>
                <p>お問い合わせの種類：${data.type ?? ''}</p>
                <p>お問い合わせ内容：${data.content ?? ''}</p>
                <form method="POST" action="/admin/contacts/${data.id}" onsubmit="return confirm('本当に削除しますか？');">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit">削除</button>
                </form>
            `;
                    document.getElementById('modal-body').innerHTML = html;
                    document.getElementById('modal').style.display = 'flex';
                });
        }
        document.getElementById('close-modal').onclick = function() {
            document.getElementById('modal').style.display = 'none';
        };
    </script>

</body>


</html>