<?php

namespace App\Http\Requests\Admin\Profile;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Sex;

class UpdateInformation2Request extends FormRequest
{
    protected $errorBag = 'updateProfileInformation2';

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
        $sexValues = collect(Sex::cases())->map(fn ($item) => $item->value)->join(',');

        return [
            'sex_code' => ['required', 'string', 'in:' . $sexValues],
            // 'age' => ['nullable', 'integer', 'min:0', 'max:150'],
            'date_of_birth' => ['nullable', 'date', 'before:today', 'after:1900-01-01'],
            'phone' => ['nullable', 'japan_phone'],
            'postal_code' => ['nullable', 'string'],
            'prefecture_id' => ['nullable', 'integer'],
            'address1' => ['nullable', 'string'],
            'address2' => ['nullable', 'string'],
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
            'sex_code' => '性別',
            // 'age' => '年齢',
            'date_of_birth' => '生年月日',
            'phone' => '電話番号',
            'postal_code' => '郵便番号',
            'prefecture_id' => '都道府県',
            'address1' => '市区町村',
            'address2' => 'ビル・マンション名・号室',
        ];
    }
}
