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
                    <td>{{ $contact->category->name ?? '-' }}</td>
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
        const modal = document.getElementById('modal');
        const modalBody = document.getElementById('modal-body');
        const closeModalBtn = document.getElementById('close-modal');
        const detailButtons = document.querySelectorAll('.detail-btn');

        function closeModal() {
            modal.style.display = 'none';
        }

        detailButtons.forEach(button => {
            button.addEventListener('click', function() {
                const contactId = this.dataset.id;

                fetch(`/admin/contacts/${contactId}`)
                    .then(res => {
                        if (!res.ok) throw new Error('Network response was not ok');
                        return res.json();
                    })
                    .then(data => {
                        console.log(data);
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        let html = `
    <table class="modal-detail-table">
      <tr><th>お名前</th><td>${data.last_name}　${data.first_name}</td></tr>
      <tr><th>性別</th><td>${data.gender}</td></tr>
      <tr><th>メールアドレス</th><td>${data.email}</td></tr>
      <tr><th>電話番号</th><td>${data.tel ?? ''}</td></tr>
      <tr><th>住所</th><td>${data.address ?? ''}</td></tr>
      <tr><th>建物名</th><td>${data.building ?? ''}</td></tr>
      <tr><th>お問い合わせの種類</th><td>${data.category ? data.category.name : '-'}</td></tr>
      <tr>
        <th>お問い合わせ内容</th>
        <td style="white-space:pre-line;">${data.content ?? ''}</td>
      </tr>
    </table>
    <div style="text-align:center; margin-top: 32px;">
      <form method="POST" action="/admin/contacts/${data.id}" style="display:inline-block;" onsubmit="return confirm('本当に削除しますか？');">
        <input type="hidden" name="_token" value="${csrfToken}">
        <input type="hidden" name="_method" value="DELETE">
        <button type="submit" class="delete-btn">削除</button>
      </form>
    </div>
`;


                        modalBody.innerHTML = html;
                        modal.style.display = 'flex';

                        // 削除ボタンイベント
                        document.querySelector('.delete-btn').onclick = function() {
                            if (confirm('本当に削除しますか？')) {
                                fetch(`/admin/contacts/${data.id}`, {
                                        method: 'DELETE',
                                        headers: {
                                            'X-CSRF-TOKEN': csrfToken,
                                            'Accept': 'application/json'
                                        }
                                    })
                                    .then(res => res.json())
                                    .then(res => {
                                        alert(res.message || '削除しました');
                                        location.reload();
                                    })
                                    .catch(err => {
                                        alert('削除に失敗しました');
                                    });
                            }
                        };
                    })
                    .catch(error => {
                        alert('エラーが発生しました。詳細を読み込めませんでした。');
                    });
            });
        });

        closeModalBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                closeModal();
            }
        });
    });
</script>
@endsection