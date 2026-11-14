<?php

namespace App\Core\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    public function findByUuid(string $uuid): ?Model;

    public function paginate(int $perPage = 10, array $filters = [], string $sort = 'created_at', string $order = 'desc'): LengthAwarePaginator;

    public function create(array $attributes): Model;

    public function update(Model $model, array $attributes): bool;

    public function delete(Model $model): bool;
}
