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
    protected $extensions = ['WithDrafted', 'WithoutDrafted', 'OnlyDrafted'];

    /**
     * Initialize the soft deleting trait for an instance.
     *
     * @return void
     */
    public function initializeVersionedScope()
    {
        $this->dates[] = $this->getDraftedAtColumn();
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
        $builder->whereNull($model->getQualifiedDraftedAtColumn());
    }

    /**
     * Add the without-trashed extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addWithoutDrafted(Builder $builder)
    {
        $builder->macro('withoutDrafted', function (Builder $builder) {
            $model = $builder->getModel();

            $builder->withoutGlobalScope($this)->whereNull(
                $model->getQualifiedDraftedAtColumn()
            );

            return $builder;
        });
    }

    /**
     * Add the with-versions extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addWithDrafted(Builder $builder)
    {
        $builder->macro('withDrafted', function (Builder $builder, $withDrafted = true) {
            if (! $withDrafted) {
                return $builder->withoutDrafted();
            }
            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Add the only-trashed extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    protected function addOnlyDrafted(Builder $builder)
    {
        $builder->macro('onlyDrafted', function (Builder $builder) {
            $model = $builder->getModel();

            $builder->withoutGlobalScope($this)->whereNotNull(
                $model->getQualifiedDraftedAtColumn()
            );

            return $builder;
        });
    }
}
