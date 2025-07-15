<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AdminController extends Controller
{
    public function export(Request $request)
    {
        // エクスポート処理をここに実装
        // 例: CSVファイルの生成、ダウンロードなど
        // 例: 検索条件に応じて取得
        $contacts = \App\Models\Contact::query();

        if ($request->filled('name')) {
            $contacts->where('name', 'like', '%' . $request->name . '%');
        }
        // 必要に応じてgender/type/date/email等も追加

        $contacts = $contacts->get();

        // CSV生成
        $csvHeader = ['名前', '性別', 'メールアドレス', 'お問い合わせの種類'];
        $csvData = [];
        foreach ($contacts as $contact) {
            $csvData[] = [
                $contact->name,
                $contact->gender,
                $contact->email,
                $contact->type,
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

        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
