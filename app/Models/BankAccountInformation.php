<?php
/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2022/10/02
 * @author      Kazuki Kimura <kazu-kimura@knsw.co.jp>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Traits\AuthorTrait;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class BankAccountInformation extends Model
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    use AuthorTrait;
    use Cachable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'bank_name',
        'bank_branch_name',
        'bank_account_holder_type_code',
        'bank_account_number',
        'bank_account_holder_name',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
    ];

    protected $appends = [
        'modified_at',
        'created_at_formated',
        'created_at_formated_only_date',
        'updated_at_formated',
        'updated_at_formated_only_date',
        'deleted_at_formated',
        'deleted_at_formated_only_date',
    ];

    protected $casts = [
        'modified_at' => 'datetime',
        'created_at_formated' => 'datetime',
        'created_at_formated_only_date' => 'datetime',
        'updated_at_formated' => 'datetime',
        'updated_at_formated_only_date' => 'datetime',
        'deleted_at_formated' => 'datetime',
        'deleted_at_formated_only_date' => 'datetime',
    ];

    /**
     * この商品に紐づくユーザー
     */
    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }
}
