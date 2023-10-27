<?php

/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2023/02/07
 * @author      Kazuki Kimura <kazu-kimura@knsw.co.jp>
 */

namespace App\Enums;

use BenSampo\Enum\Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;

final class PermissionType extends Enum implements LocalizedEnum
{
    // Posts
    public const READ_POSTS = 'read posts';
    public const EDIT_POSTS = 'edit posts';
    public const DELETE_POSTS = 'delete posts';
}
