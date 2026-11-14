<?php

namespace App\Core\Services;

use Illuminate\Support\Facades\DB;
use Throwable;

abstract class BaseService
{
    /**
     * Execute callback inside a database transaction (CODE-08, DB-60).
     *
     * @template T
     * @param callable(): T $callback
     * @return T
     * @throws Throwable
     */
    protected function transactional(callable $callback): mixed
    {
        return DB::transaction($callback);
    }
}
