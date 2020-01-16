<?php

namespace NeonDigital\Drafting\Drafters;

use NeonDigital\Drafting\Interfaces\DrafterInterface;
use NeonDigital\Drafting\Draftable;

class EloquentDrafter implements DrafterInterface
{
    public function firstOrCreate(Draftable $model)
    {
        return $model->draft ?: $this->create($model);
    }

    public function create(Draftable $model)
    {
        $new = $model->replicate();
        $new->drafted_at = now();
        $new->draft_parent_id = $model->id;
        $new->save();
        return $new;
    }
}