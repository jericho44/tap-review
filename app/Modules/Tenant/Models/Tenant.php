<?php

namespace App\Modules\Tenant\Models;

use App\Core\Models\BaseUuidModel;
use App\Models\User;
use App\Modules\Client\Models\Client;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tenant extends BaseUuidModel
{
    protected $fillable = [
        'name',
        'slug',
        'status',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }
}
