<?php

namespace Modules\Organization\Models;

use App\Models\User;
use App\Shared\Tenancy\Traits\BelongsToOrganization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Organization\Enums\OrganizationVersionStatus;

/** Version snapshot của config tổ chức — giống style SopVersion (plain Model, append-mostly). */
class OrganizationVersion extends Model
{
    use BelongsToOrganization;

    public $timestamps = false;

    protected $fillable = [
        'uuid',
        'organization_id',
        'version',
        'config_json',
        'checksum',
        'status',
        'effective_at',
        'change_reason',
        'created_by',
        'approved_by',
        'approved_at',
        'created_at',
    ];

    protected $casts = [
        'config_json'  => 'array',
        'status'       => OrganizationVersionStatus::class,
        'effective_at' => 'datetime',
        'approved_at'  => 'datetime',
        'created_at'   => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $model): void {
            $model->uuid ??= (string) \Illuminate\Support\Str::uuid();
            $model->created_at ??= now();
        });
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    // ── Relationships ────────────────────────────────────────────────────────

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function createdByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approvedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
