<?php

/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2023/07/04
 * @author      Kazuki Kimura <kazu-kimura@knsw.co.jp>
 */

namespace App\Enums;

use BenSampo\Enum\Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;

final class RoleType extends Enum implements LocalizedEnum
{
    public const SYSTEM_ADMIN = 'system admin';
    public const ADMIN = 'admin';
    public const STAFF = 'staff';
}
