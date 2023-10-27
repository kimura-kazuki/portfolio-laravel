<?php
/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2022/10/17
 * @author      Kazuki Kimura <kazu-kimura@knsw.co.jp>
 */

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class BankAccountUpdateRequest extends FormRequest
{
    protected $errorBag = 'adminUserBankAccountUpdate';

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
            'bank_name' => ['required', 'string', 'max:255'],
            'bank_branch_name' => ['required', 'string', 'max:255'],
            'bank_account_holder_type_code' => ['required', 'in:1,2'],
            'bank_account_number' => ['required', 'string', 'max:255'],
            'bank_account_holder_name' => ['required', 'string', 'max:255'],
        ];
    }

    /**
     * エラーメッセージ
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }

    /**
     * Set custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'bank_name' => '銀行名',
            'bank_branch_name' => '銀行支店名',
            'bank_account_holder_type_code' => '口座種別',
            'bank_account_number' => '口座番号',
            'bank_account_holder_name' => '口座名義',
        ];
    }
}
