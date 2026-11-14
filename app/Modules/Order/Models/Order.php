<?php

namespace App\Modules\Order\Models;

use App\Core\Models\BaseUuidModel;
use App\Modules\Client\Models\Client;
use App\Modules\Tenant\Models\Tenant;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends BaseUuidModel
{
    protected $fillable = [
        'tenant_id',
        'client_id',
        'order_number',
        'business_name',
        'contact_name',
        'whatsapp',
        'google_review_url',
        'package_name',
        'point_count',
        'shipping_address',
        'status',
        'total_amount',
        'currency',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:4',
            'point_count' => 'integer',
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
}
