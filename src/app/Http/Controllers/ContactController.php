<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest; //フォームリクエスト
use App\Models\Contact; //お問い合わせ
use App\Models\Category; //カテゴリーお問い合わせの種類


class ContactController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::query();

        // 名前
        if ($request->filled('name')) {
            $name = $request->input('name');
            $query->where(function ($q) use ($name) {
                $q->where('first_name', 'like', "%{$name}%")
                    ->orWhere('last_name', 'like', "%{$name}%")
                    ->orWhereRaw("CONCAT(last_name, first_name) LIKE ?", ["%{$name}%"]);
            });
        }
        // メール
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->input('email') . '%');
        }
        // 性別
        if ($request->filled('gender') && $request->input('gender') != 'all') {
            $query->where('gender', $request->input('gender'));
        }
        // 種別
        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }
        // 日付
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->input('date'));
        }

        $contacts = $query->with('category')->paginate(7)->appends($request->all());

        return view('admin.index', compact('contacts'));
    }
    public function show($id)
    {
        //$contact = Contact::with('category')->findOrFail($id);
        $contact = \App\Models\Contact::with('category')->findOrFail($id);
        return response()->json($contact);
    }
    //お問い合わせ入力画面
    public function create(Request $request)
    {
        $categories = Category::all();
        // セッションのold()をBladeで使うためだけにGETで返す。   
        return view('contacts.create', compact('categories'));
    }
    //お問い合わせ確認画面
    public function confirm(ContactRequest $request)
    {
        $inputs = $request->all();
        // 性別（ラジオ値を文字に変換）
        $gender = $inputs['gender'] ?? '';
        $genderText = $gender; // そのまま「男性」「女性」「その他」ラジオボタン値を渡してる場合

        // カテゴリー名取得
        $categoryName = '';
        if (!empty($inputs['category_id'])) {
            $category = Category::find($inputs['category_id']);
            $categoryName = $category ? $category->name : '';
        }
        // 確認画面に渡す

        return view('contacts.confirm', compact('inputs', 'genderText', 'categoryName'));
    }
    public function back(Request $request)
    {

        // 入力値をセッションに保存してリダイレクト
        return redirect()->route('contacts.create')->withInput($request->except('_token'));
    }



    // 保存（送信）処理
    public function store(Request $request)
    {
        // データ保存
        \App\Models\Contact::create($request->all());

        // サンクスページへ
        return redirect()->route('contacts.thanks');
    }



    //お問い合わせ完了画面
    public function complete(Request $request)
    {
        // お問い合わせ内容を保存する処理
        return view('contact.complete');
    }
    public function destroy($id)
    {
        $contact = \App\Models\Contact::findOrFail($id);
        $contact->delete();
        return response()->json(['message' => '削除しました']);
    }
}
