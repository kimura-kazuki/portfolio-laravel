<?php
/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2022/10/14
 * @author      Kazuki Kimura <kazu-kimura@knsw.co.jp>
 */

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Sex;

class UserUpdateRequest extends FormRequest
{
    protected $errorBag = 'adminUserUpdate';

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
        $sexCodeValues = implode(',', Sex::toArray());

        return [
            // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'membership_number' => ['nullable', 'integer'],
            'name' => ['required', 'string', 'max:255'],
            'name_kana' => ['required', 'katakana', 'max:255'],
            'sex_code' => ['required', 'in:' . $sexCodeValues],
            'date_of_birth' => ['nullable', 'date', 'before:today', 'after:1900-01-01'],
            'introducer_code' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * エラーメッセージ
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name_kana.katakana' => ':attributeはカタカナで入力してください。',
        ];
    }

    /**
     * Set custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            // 'email' => 'メールアドレス',
            'name' => '名前',
            'name_kana' => '名前（カナ）',
            'sex_code' => '性別',
            'date_of_birth' => '生年月日',
            'introducer_code' => '紹介者コード',
        ];
    }
}
