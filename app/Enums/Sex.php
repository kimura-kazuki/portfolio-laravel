<?php

/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2022/02/25
 * @author      Kazuki Kimura <kazu-kimura@knsw.co.jp>
 */

namespace App\Enums;

use App\Traits\EnumTrait;

/**
 * Sex
 * ISO 5218に準拠する
 * https://ja.wikipedia.org/wiki/ISO_5218
 */
enum Sex: string
{
    use EnumTrait;

    case NotKnown = '0';
    case Male = '1';
    case Female = '2';
    case NotApplicable = '9';

    public function label(): string
    {
        return match ($this) {
            self::NotKnown  => '不明',
            self::Male  => '男性',
            self::Female => '女性',
            self::NotApplicable => '適用不能',
        };
    }
}
