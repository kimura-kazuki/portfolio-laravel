<?php

/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2022/02/11
 * @author      Kazuki Kimura <kazu-kimura@knsw.co.jp>
 */

namespace App\Traits;

use App\Observers\AuthorObserver;
use Illuminate\Support\Carbon;

trait AuthorTrait
{
    public static function bootAuthorObservable()
    {
        self::observe(AuthorObserver::class);
    }

    /**
     * getModifiedAtAttribute
     */
    public function getModifiedAtAttribute(): Carbon|\Carbon\Carbon|null
    {
        return ($this->updated_at) ? $this->updated_at : $this->created_at;
    }

    /**
     * getCreatedAtFormatedFormatAttribute
     */
    public function getCreatedAtFormatedAttribute(): string
    {
        return $this->created_at->format('Y-m-d H:i');
    }

    /**
     * getCreatedAtFormatedOnlyDateAttribute
     */
    public function getCreatedAtFormatedOnlyDateAttribute(): string
    {
        return $this->created_at->format('Y-m-d');
    }

    /**
     *  getUpdatedAtFormatedAttribute
     */
    public function getUpdatedAtFormatedAttribute(): string
    {
        return $this->updated_at->format('Y-m-d H:i');
    }

    /**
     * getUpdatedAtFormatedOnlyDateAttribute
     */
    public function getUpdatedAtFormatedOnlyDateAttribute(): string
    {
        return $this->updated_at->format('Y-m-d');
    }

    /**
     * getDeletedAtFormatedFormatAttribute
     */
    public function getDeletedAtFormatedAttribute(): string | null
    {
        return optional($this->deleted_at)->format('Y-m-d H:i');
    }

    /**
     * getDeletedAtFormatedOnlyDateAttribute
     */
    public function getDeletedAtFormatedOnlyDateAttribute(): string | null
    {
        return optional($this->deleted_at)->format('Y-m-d');
    }
}
