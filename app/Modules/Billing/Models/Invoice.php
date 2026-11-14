<?php

namespace App\Modules\Billing\Models;

use App\Core\Models\BaseUuidModel;
use App\Core\Scopes\TenantScope;
use App\Modules\Client\Models\Client;
use App\Modules\Order\Models\Order;
use App\Modules\Tenant\Models\Tenant;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends BaseUuidModel
{
    protected $fillable = [
        'tenant_id',
        'client_id',
        'order_id',
        'invoice_number',
        'amount',
        'currency',
        'status',
        'due_date',
        'paid_at',
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
            'amount' => 'decimal:4',
            'due_date' => 'datetime',
            'paid_at' => 'datetime',
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

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
