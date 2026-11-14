<?php

namespace App\Core\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class EloquentBaseRepository implements BaseRepositoryInterface
{
    /**
     * @var class-string<Model>
     */
    protected string $modelClass;

    /**
     * Whitelist of sortable columns (DB-63).
     */
    protected array $allowedSortColumns = ['created_at', 'updated_at'];

    public function __construct()
    {
        $this->modelClass = $this->getModelClass();
    }

    abstract protected function getModelClass(): string;

    protected function query(): Builder
    {
        return app($this->modelClass)->newQuery();
    }

    public function findByUuid(string $uuid): ?Model
    {
        return $this->query()->where('uuid', $uuid)->first();
    }

    public function paginate(
        int $perPage = 10,
        array $filters = [],
        string $sort = 'created_at',
        string $order = 'desc'
    ): LengthAwarePaginator {
        $perPage = min(max(1, $perPage), 100);
        $order = strtolower($order) === 'asc' ? 'asc' : 'desc';

        if (! in_array($sort, $this->allowedSortColumns, true)) {
            $sort = 'created_at';
        }

        $query = $this->query();
        $this->applyFilters($query, $filters);

        return $query->orderBy($sort, $order)->paginate($perPage);
    }

    protected function applyFilters(Builder $query, array $filters): void
    {
        // Custom module filters override this method
    }

    public function create(array $attributes): Model
    {
        return $this->query()->create($attributes);
    }

    public function update(Model $model, array $attributes): bool
    {
        return $model->update($attributes);
    }

    public function delete(Model $model): bool
    {
        return (bool) $model->delete();
    }
}
