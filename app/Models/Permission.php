<?php
/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2023/02/07
 * @author      Kazuki Kimura <kazu-kimura@knsw.co.jp>
 */

namespace App\Models;

use App\Enums\PermissionType as PermissionEnum;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    public function getDescriptionAttribute(): string
    {
        $name = $this->name;
        $description = PermissionEnum::getDescription($name);

        return $description !== '' ? $description : $name;
    }

    public function isSystemDefined(): bool
    {
        return PermissionEnum::hasValue($this->name);
    }
}
