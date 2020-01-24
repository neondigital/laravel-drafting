<?php

namespace NeonDigital\Drafting;

trait Draftable
{
    /**
     * Boot up the trait
     *
     * @return void
     */
    public static function bootDraftable()
    {
        static::addGlobalScope(new DraftScope);
    }

    /**
     * Get the draft for the current version
     *
     * @return void
     */
    public function draft()
    {
        return $this->hasOne(self::class, 'draft_parent_id')->onlyDrafted();
    }

    public function isDraft()
    {
        return (bool) $this->drafted_at;
    }

    public function publishedParent()
    {
        return $this->belongsTo(self::class, 'draft_parent_id');
    }

    /**
     * Initialize the versioned trait for an instance.
     *
     * @return void
     */
    public function initializeDraftable()
    {
        $this->dates[] = $this->getDraftedAtColumn();
    }

    /**
     * Get the name of the "versioned at" column.
     *
     * @return string
     */
    public function getDraftedAtColumn()
    {
        return defined('static::DRAFTED_AT') ? static::DRAFTED_AT : 'drafted_at';
    }

    /**
     * Get the fully qualified "versioned at" column.
     *
     * @return string
     */
    public function getQualifiedDraftedAtColumn()
    {
        return $this->qualifyColumn($this->getDraftedAtColumn());
    }
}
