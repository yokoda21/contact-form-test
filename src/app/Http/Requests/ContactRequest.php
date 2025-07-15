<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'last_name'      => 'required|string|max:50',
            'first_name'     => 'required|string|max:50',
            'gender'         => 'required|in:男性,女性,その他',
            'email'          => 'required|email',
            'tel'            => ['required', 'digits_between:5,11', 'regex:/^[0-9]+$/'],
            'address'        => 'required|string|max:100',
            'building'       => 'nullable|string|max:100',
            'category_id'    => 'required|exists:categories,id',
            'content'        => 'required|string|max:120',
        ];
    }
    public function messages()
    {
        return [
            'last_name.required'   => '姓を入力してください',
            'first_name.required'  => '名を入力してください',
            'gender.required'      => '性別を選択してください',
            'email.required'       => 'メールアドレスを入力してください',
            'email.email'          => 'メールアドレスはメール形式で入力してください',
            'tel.required'         => '電話番号を入力してください',
            'tel.digits_between'   => '電話番号は5桁までの数字で入力してください',
            'tel.regex'            => '電話番号は5桁までの数字で入力してください',
            'address.required'     => '住所を入力してください',
            'category_id.required' => 'お問い合わせの種類を選択してください',
            'category_id.exists'   => 'お問い合わせの種類を選択してください',
            'content.required'     => 'お問い合わせ内容を入力してください',
            'content.max'          => 'お問合せ内容は120文字以内で入力してください',
        ];
    }
}
