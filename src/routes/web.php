<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;

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

/*トップページ（ログイン済みユーザーのみトップページ、Fortify使用し、RouteServiceProvider.phpのpublic const HOME = '/dashboard';をpublic const HOME = '/admin/contacts';へ変更した）
*/

//管理画面
Route::get('/admin/contacts', [ContactController::class, 'index'])->name('admin.contacts.index');
Route::get('/admin/contacts/{id}', [ContactController::class, 'show'])->name('admin.contacts.show');
Route::delete('/admin/contacts/{id}', [ContactController::class, 'destroy'])->name('admin.contacts.destroy');
Route::get('/admin/contacts/export', [ContactController::class, 'export'])->name('admin.contacts.export');

// お問い合わせフォーム入力画面
Route::get('/contacts/create', [ContactController::class, 'create'])->name('contacts.create');
// お問い合わせフォーム確認画面
Route::post('/contacts/confirm', [ContactController::class, 'confirm'])->name('contacts.confirm');
// お問い合わせフォーム修正画面(確認画面からの戻り)
Route::post('/contacts/back', [ContactController::class, 'back'])->name('contacts.back');
// お問い合わせフォーム完了画面、DB保存とサンクスページへ
Route::post('/contacts/store', [ContactController::class, 'store'])->name('contacts.store');
