<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Traits\AuthorTrait;
use App\Enums\UserRole;
use App\Enums\Sex;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;
    use HasRoles;
    use AuthorTrait;
    use Cachable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'membership_number',
        'company_id',
        'name',
        'name_kana',
        'email',
        'email_verified_at',
        'password',
        'phone',
        'sex_code',
        // 'age',
        'date_of_birth',
        'role',
        'introducer_code',
        'google_id',
        'is_approved',
        'is_approved_kyc',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
        'sex_name',
        'sex_label',
        'role_name',
        'role_label',
        'created_at_formated',
        'deleted_at_formated',
        'is_deleted',
        'is_system_admin',
        'is_admin',
    ];

    /**
     * for eager loading
     *
     * @var array
     */
    protected $with = [
        'company',
        'userLocations',
        'bankAccountInformation',
        // 'role',
    ];

    /**
     * ユーザーの性別を取得
     */
    public function getSexNameAttribute(): string|null
    {
        // if (empty($this->sex_code)) {
        //     return null;
        // }
        return optional(Sex::tryFrom($this->sex_code))->name ?? Sex::NotKnown->name;
    }

    /**
     * ユーザーの性別を取得
     */
    public function getSexLabelAttribute(): string|null
    {
        // if (empty($this->sex_code)) {
        //     return null;
        // }
        return optional(Sex::tryFrom($this->sex_code))->label() ?? Sex::NotKnown->label();
    }

    /**
     * getRoleNameFormatAttribute
     */
    public function getRoleNameAttribute(): string
    {
        return optional(UserRole::tryFrom($this->role))->name ?? UserRole::Staff->name;
    }

    /**
     * getRoleNameFormatAttribute
     */
    public function getRoleLabelAttribute()
    {
        return optional(UserRole::tryFrom($this->role))->label() ?? UserRole::Staff->label();
    }

    /**
     * getCreatedAtFormatedFormatAttribute
     */
    public function getCreatedAtFormatedAttribute(): string
    {
        return $this->created_at->format('Y-m-d H:i');
    }

    /**
     * getDeletedAtFormatedFormatAttribute
     */
    public function getDeletedAtFormatedAttribute(): string | null
    {
        return optional($this->deleted_at)->format('Y-m-d H:i');
    }

    /**
     * getIsDeletedAttribute
     */
    public function getIsDeletedAttribute(): bool
    {
        return $this->trashed();
        // // return !empty($this->deleted_at);
        // $a = !empty($this->deleted_at);
        // \Log::debug('getIsDeletedAttribute', [$a]);
        // return $a;
    }

    /**
     * getIsSystemAdminAttribute
     */
    public function getIsSystemAdminAttribute(): bool
    {
        return $this->hasRole('system admin');
    }

    /**
     * getIsSystemAdminAttribute
     */
    public function getIsAdminAttribute(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Scope a query to only include admin users.
     */
    public function scopeRole(Builder $query, string $roleName): Builder
    {
        return $query->where('role', UserRole::find($roleName)->value);
    }

    /**
     * このユーザーに紐づく住所
     */
    public function userLocations(): HasMany
    {
        return $this->hasMany(UserLocation::class);
    }

    /**
     * bankAccountInformation
     */
    public function bankAccountInformation(): HasMany
    {
        return $this->hasMany(BankAccountInformation::class);
    }

    /**
     * このユーザーに属する会社
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
