<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*トップページ（ログイン済みユーザーのみトップページ、Fortify使用し、RouteServiceProvider.phpのpublic const HOME = '/dashboard';をpublic const HOME = '/admin/contacts';→さらに'/admin/'へ変更した,確認テストのルーティング情報に合わせる）
*/

// お問い合わせフォーム入力画面
Route::get('/', [ContactController::class, 'create'])->name('contacts.create');
// お問い合わせフォーム確認画面
Route::post('/confirm', [ContactController::class, 'confirm'])->name('contacts.confirm');
// お問い合わせフォーム修正画面(確認画面からの戻り)
Route::post('/back', [ContactController::class, 'back'])->name('contacts.back');
// お問い合わせフォーム完了画面、DB保存とサンクスページへ
Route::post('/store', [ContactController::class, 'store'])->name('contacts.store');
// サンクスページ
Route::get('/thanks', function () {
    return view('contacts.thanks');
})->name('contacts.thanks');

//エクスポートのルート
Route::get('/admin/export', [AdminController::class, 'export'])->name('admin.export');

//管理画面
Route::get('/admin', [ContactController::class, 'index'])->name('admin.index');
Route::get('/admin/{id}', [ContactController::class, 'show'])->name('admin.show');
Route::delete('/admin/{id}', [ContactController::class, 'destroy'])->name('admin.destroy');
