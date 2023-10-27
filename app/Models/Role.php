<?php
/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2023/02/07
 * @author      Kazuki Kimura <kazu-kimura@knsw.co.jp>
 */

namespace App\Models;

use App\Enums\RoleType as RoleEnum;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    public function scopeNotSystemAdmin($query)
    {
        return $query->where('name', '<>', RoleEnum::SYSTEM_ADMIN);
    }

    public function getDescriptionAttribute(): string
    {
        $name = $this->name;
        $description = RoleEnum::getDescription($name);

        return $description !== '' ? $description : $name;
    }

    public function isSystemDefined(): bool
    {
        return RoleEnum::hasValue($this->name);
    }

    public function isSystemAdmin(): bool
    {
        return $this->name === RoleEnum::SYSTEM_ADMIN;
    }

    public function isAdmin(): bool
    {
        return $this->name === RoleEnum::ADMIN;
    }
}
