<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Response;

class AdminController extends Controller
{
    public function index()
    {
        $contacts = Contact::paginate(7);
        // 管理画面のインデックスページを表示
        return view('admin.index', compact('contacts'));
    }

    public function export(Request $request)
    {
        // エクスポート処理をここに実装
        // 例: CSVファイルの生成、ダウンロードなど
        // 例: 検索条件に応じて取得
        $contacts = \App\Models\Contact::query();
        // リレーションも取得する
        $contacts = \App\Models\Contact::with('category');

        // 名前検索は、first_nameまたはlast_nameで対応
        if ($request->filled('name')) {
            $contacts->where(function ($query) use ($request) {
                $query->where('first_name', 'like', '%' . $request->name . '%')
                    ->orWhere('last_name', 'like', '%' . $request->name . '%');
            });
        }

        $contacts = $contacts->get();

        // CSV生成
        $csvHeader = ['名前', '性別', 'メールアドレス', 'お問い合わせの種類'];
        $csvData = [];
        foreach ($contacts as $contact) {
            $csvData[] = [
                $contact->last_name . ' ' . $contact->first_name, //名前と苗字
                $contact->gender,
                $contact->email,
                $contact->category ? $contact->category->name : ' ', // お問い合わせの種類
            ];
        }

        $filename = 'contacts_' . date('Ymd_His') . '.csv';
        $handle = fopen('php://temp', 'r+');
        fputcsv($handle, $csvHeader);
        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }
        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        // ここで文字コードをSJISに変換
        $csv = mb_convert_encoding($csv, 'SJIS-win', 'UTF-8');

        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
