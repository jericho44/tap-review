<?php

namespace App\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

abstract class BaseUuidModel extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Primary key is internal BIGINT.
     */
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    /**
     * The internal numeric ID MUST NEVER be exposed in JSON responses or APIs (DB-13).
     */
    protected $hidden = [
        'id',
    ];

    /**
     * Boot model to automatically assign UUIDv7 on creating (DB-11).
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Model $model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    /**
     * Use UUID for route model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}
