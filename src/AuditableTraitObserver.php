<?php

namespace Ricardo\Auditable;

use Illuminate\Database\Eloquent\Model;
use Auth;

class AuditableTraitObserver
{
    /**
     * Model's creating event hook.
     *
     * @param Model $model
     */
    public function creating(Model $model)
    {
        if (! $model->created_by) {
            $model->created_by = $this->getAuthenticatedUserId();
        }

        if (! $model->updated_by) {
            $model->updated_by = $this->getAuthenticatedUserId();
        }
    }

    /**
     * Get authenticated user id depending on model's auth guard.
     *
     * @return int
     */
    protected function getAuthenticatedUserId()
    {
        return auth()->check() ? Auth::user()->email : 0;
    }

    /**
     * Model's updating event hook.
     *
     * @param Model $model
     */
    public function updating(Model $model)
    {
        if (! $model->isDirty('updated_by')) {
            $model->updated_by = $this->getAuthenticatedUserId();
        }
    }
    /**
     * Model's deleting event hook.
     *
     * @param Model $model
     */
    public function deleting(Model $model)
    {
        $model->updated_by = $this->getAuthenticatedUserId();
        $model->save();
    }
}
