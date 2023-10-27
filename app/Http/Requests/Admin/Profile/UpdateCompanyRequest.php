<?php

namespace App\Http\Requests\Admin\Profile;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Sex;

class UpdateCompanyRequest extends FormRequest
{
    protected $errorBag = 'userCompanyUpdate';

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
            'company_id' => ['nullable', 'integer', 'exists:companies,id'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'representative' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'japan_phone'],
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
            'phone.japan_phone' => '電話番号はハイフンなしの半角数字で入力してください。',
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
            'company_id' => '会社ID',
            'company_name' => '会社名',
            'representative' => '代表者名',
            'address' => '住所',
            'phone' => '電話番号',
        ];
    }
}
