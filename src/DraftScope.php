<?php

namespace NeonDigital\Drafting;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class DraftScope implements Scope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = ['WithUnpublished'];

    /**
     * Initialize the soft deleting trait for an instance.
     *
     * @return void
     */
    public function initializeVersionedScope()
    {
        $this->dates[] = $this->getVersionedAtColumn();
    }

    /**
     * Extend the query builder with the needed functions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    public function extend(Builder $builder)
    {
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }
    }

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        // $builder->whereHas('version', function ($query) {
        //     $query->whereNotNull('published_at');
        // });
    }

        /**
     * Add the with-versions extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addWithUnpublished(Builder $builder)
    {
        $builder->macro('withUnpublished', function (Builder $builder, $withUnpublished = true) {
            return $builder->withoutGlobalScope($this);
        });
    }
}
