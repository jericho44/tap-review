<?php

namespace App\Modules\Client\Models;

use App\Core\Models\BaseUuidModel;
use App\Core\Scopes\TenantScope;
use App\Modules\Point\Models\Point;
use App\Modules\Tenant\Models\Tenant;
use App\Modules\Theme\Models\Theme;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends BaseUuidModel
{
    protected $fillable = [
        'tenant_id',
        'theme_id',
        'business_name',
        'category',
        'contact_name',
        'email',
        'whatsapp',
        'address',
        'slug',
        'google_review_url',
        'status',
        'package_plan',
        'active_until',
        'metadata',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected static function booted(): void
    {
        parent::booted();
        static::addGlobalScope(new TenantScope);
    }

    protected function casts(): array
    {
        return [
            'active_until' => 'datetime',
            'metadata' => 'array',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }

    public function points(): HasMany
    {
        return $this->hasMany(Point::class);
    }
}
