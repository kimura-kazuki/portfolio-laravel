<?php
/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2023/06/27
 * @author      Kazuki Kimura <kazu-kimura@knsw.co.jp>
 */

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;

class AuthorObserver
{
    public function creating(Model $model)
    {
        if (property_exists($model, 'created_by') && auth()->check()) {
            $model->created_by = auth()->user()->id ?? null;
        }
    }

    public function updating(Model $model)
    {
        if (property_exists($model, 'updated_by') && auth()->check()) {
            $model->updated_by = auth()->user()->id ?? null;
        }
    }

    public function saving(Model $model)
    {
        if (property_exists($model, 'updated_by') && auth()->check()) {
            $model->updated_by = auth()->user()->id ?? null;
        }
    }

    public function deleting(Model $model)
    {
        if (property_exists($model, 'deleted_by') && auth()->check()) {
            $model->deleted_by = auth()->user()->id ?? null;
        }
    }

    public function restoring(Model $model)
    {
        if (property_exists($model, 'restored_by') && auth()->check()) {
            $model->restored_by = auth()->user()->id ?? null;
        }
    }
}
