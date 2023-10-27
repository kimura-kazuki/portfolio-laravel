<?php

/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2023/07/03
 * @author      Kazuki Kimura <kazu-kimura@knsw.co.jp>
 */

namespace App\Enums;

use App\Traits\EnumTrait;

enum UserRole: string
{
    use EnumTrait;

    case SystemAdmin = 'system admin';
    case Admin = 'admin';
    case Staff = 'staff';

    public static function find(string $key): ?self
    {
        return match ($key) {
            'SystemAdmin' => self::SystemAdmin,
            'Admin' => self::Admin,
            'Staff' => self::Staff,
            default     => null,
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::SystemAdmin  => 'システム管理者',
            self::Admin  => '運営者',
            self::Staff  => 'スタッフ',
        };
    }
}
