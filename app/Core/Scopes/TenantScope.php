<?php

namespace App\Core\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class TenantScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        // If user is authenticated and belongs to a tenant, restrict to tenant_id
        if (Auth::check()) {
            $user = Auth::user();
            if (isset($user->tenant_id) && $user->tenant_id !== null && ! ($user->is_super_admin ?? false)) {
                $builder->where($model->getTable().'.tenant_id', $user->tenant_id);
            }
        }
    }
}
