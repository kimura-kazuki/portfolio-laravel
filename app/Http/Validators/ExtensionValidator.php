<?php
/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2021/02/15
 * @author      Kazuki Kimura <kazuki.kimura@avithglobals.com>
 */

namespace App\Http\Validators;

use Illuminate\Validation\Validator;

class ExtensionValidator extends Validator
{
    /**
     * validateJapanPhone
     * 電話番号（ハイフン有り）
     * 0から始まり、市外局番1〜4桁（ゼロ抜き）-市内局番1〜4桁-加入者番号3〜4桁
     * 全部で10桁〜11桁（ハイフンなし）
     *
     * @param string $value
     * @access public
     * @return bool
     */
    public function validateJapanPhone($attribute, $value, $parameters)
    {
        return (bool) preg_match('/\A0[0-9]{9,10}\z/', $value); // ハイフンなし
        // return (bool) (preg_match('/\A0\d{1,4}-\d{1,4}-\d{3,4}\z/', $value) &&
        //     (strlen($value) === 12 || strlen($value) === 13)
        // ); // ハイフンあり
    }

    /**
     * validatePostalCode
     * 郵便番号（ハイフン無し）
     *
     * @param string $value
     * @access public
     * @return bool
     */
    public function validatePostalCode($attribute, $value, $parameters)
    {
        return (bool) preg_match('/\A[0-9]{7}\z/', $value);
    }

    /**
     * validateKataKana
     * カタカナ + スペース
     *
     * @param string $value
     * @access public
     * @return bool
     */
    public function validateKataKana($attribute, $value, $parameters)
    {
        return (bool) preg_match('/\A[ァ-ヶー 　]+\z/mu', $value);
    }
}
