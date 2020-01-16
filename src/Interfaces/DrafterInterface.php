<?php

namespace NeonDigital\Drafting\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface DrafterInterface
{
    /**
     * Get a draft from an eloquent model
     *
     * @param Model $model
     * @return void
     */
    public function create(Model $model);

    /**
     * Get the draft or create a new one
     *
     * @param Model $model
     * @return void
     */
    public function firstOrCreate(Model $model);
}