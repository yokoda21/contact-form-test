@extends('layouts.app')

@section('content')
<div class="admin-page">
    <div class="admin-container">
        <div class="admin-title">Admin</div>
        {{-- 検索フォーム --}}
        <form method="GET" action="{{ route('admin.index') }}" class="search-form">
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
            </select>
            <input type="date" name="date" value="{{ request('date') }}">
            <button type="submit" class="search-btn">検索</button>
            <button type="button" class="reset-btn" onclick="location.href='{{ route("admin.index") }}'">リセット</button>
        </form>

        {{-- エクスポートボタン --}}
        <form method="GET" action="{{ route('admin.export') }}" class="export-form">
            <input type="hidden" name="name" value="{{ request('name') }}">
            <input type="hidden" name="gender" value="{{ request('gender') }}">
            <input type="hidden" name="type" value="{{ request('type') }}">
            <input type="hidden" name="date" value="{{ request('date') }}">
            <input type="hidden" name="email" value="{{ request('email') }}">
            <button type="submit" class="export-btn">エクスポート</button>
        </form>

        {{-- ページネーション --}}
        <div class="pagination-wrapper">
            {{ $contacts->links() }}
        </div>

        {{-- 一覧テーブル --}}
        <table class="admin-table">
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
                    <td>{{ $contact->category->content ?? '-' }}</td>
                    <td>
                        <button type="button" class="detail-btn" data-id="{{ $contact->id }}">詳細</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- モーダルウィンドウ --}}
    <div id="modal" style="display:none; position:fixed; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.3); justify-content:center; align-items:center; z-index:10000;">
        <div id="modal-content" style="background:#fff; padding:24px; min-width:320px; border-radius:8px; position:relative;">
            <span id="close-modal" style="cursor:pointer; position:absolute; top:8px; right:16px; font-size:20px;">×</span>
            <div id="modal-body"></div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 必要な要素をまとめて取得
        const modal = document.getElementById('modal');
        const modalBody = document.getElementById('modal-body');
        const closeModalBtn = document.getElementById('close-modal');

        // "detail-btn" というクラスを持つ全てのボタンを取得
        const detailButtons = document.querySelectorAll('.detail-btn');

        // モーダルを閉じるための関数
        function closeModal() {
            modal.style.display = 'none';
        }

        // 取得した全ての「詳細」ボタンに対して、クリックイベントを設定
        detailButtons.forEach(button => {
            button.addEventListener('click', function() {
                // クリックされたボタンの data-id 属性からIDを取得
                const contactId = this.dataset.id;

                // サーバーからデータを取得
                fetch(`/admin/contacts/${contactId}`)
                    .then(res => {
                        if (!res.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return res.json();
                    })
                    .then(data => {
                        // CSRFトークンをmetaタグから取得
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                        // モーダルの中身を生成
                        let html = `
                        <p><strong>お名前：</strong>${data.last_name} ${data.first_name}</p>
                        <p><strong>性別：</strong>${data.gender}</p>
                        <p><strong>メールアドレス：</strong>${data.email}</p>
                        <p><strong>電話番号：</strong>${data.tel ?? ''}</p>
                        <p><strong>住所：</strong>${data.address ?? ''}</p>
                        <p><strong>建物名：</strong>${data.building ?? ''}</p>
                        <p><strong>お問い合わせの種類：</strong>${data.category ? data.category.content : '-'}</p>
                        <p><strong>お問い合わせ内容：</strong>${data.detail ?? data.content ?? ''}</p>
                        <hr>
                        <form method="POST" action="/admin/contacts/${data.id}" onsubmit="return confirm('本当に削除しますか？');">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="delete-btn">削除</button>
                        </form>
                    `;

                        // 生成したHTMLをモーダルにセットし、表示する
                        modalBody.innerHTML = html;
                        modal.style.display = 'flex';
                    })
                    .catch(error => {
                        console.error('詳細データの取得に失敗しました:', error);
                        alert('エラーが発生しました。詳細を読み込めませんでした。');
                    });
            });
        });

        // 閉じるボタン（×）にクリックイベントを設定
        closeModalBtn.addEventListener('click', closeModal);

        // モーダルの背景部分をクリックした時も閉じるように設定
        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                closeModal();
            }
        });
    });
</script>
@endsection