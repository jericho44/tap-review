<?php

namespace App\Modules\Point\Models;

use App\Core\Models\BaseUuidModel;
use App\Core\Scopes\TenantScope;
use App\Modules\Client\Models\Client;
use App\Modules\Tap\Models\Tap;
use App\Modules\Tenant\Models\Tenant;
use App\Modules\Theme\Models\Theme;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Point extends BaseUuidModel
{
    protected $fillable = [
        'tenant_id',
        'client_id',
        'custom_theme_id',
        'point_code',
        'location_label',
        'nfc_uid',
        'chip_status',
        'physical_status',
        'installed_at',
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
            'installed_at' => 'datetime',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function customTheme(): BelongsTo
    {
        return $this->belongsTo(Theme::class, 'custom_theme_id');
    }

    public function taps(): HasMany
    {
        return $this->hasMany(Tap::class);
    }
}
