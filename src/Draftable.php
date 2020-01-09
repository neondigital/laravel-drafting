<?php

namespace NeonDigital\Drafting;

trait Draftable
{
    public $uuid = null;

    public $published = true;

    /**
     * Get the version relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function version()
    {
        return $this->belongsTo(Version::class);
    }

    public static function bootVersionable()
    {
        static::addGlobalScope(new VersionScope);

        // self::creating(function ($model) {
        //     app(VersionService::class)->createVersion($model, true);
        // });
    }

    /**
     * Initialize the versioned trait for an instance.
     *
     * @return void
     */
    public function initializeVersioned()
    {
        $this->dates[] = $this->getVersionedAtColumn();
    }

    /**
     * Get the name of the "versioned at" column.
     *
     * @return string
     */
    public function getVersionedAtColumn()
    {
        return defined('static::PUBLISHED_AT') ? static::VERSIONED_AT : 'published_at';
    }

    /**
     * Get the fully qualified "versioned at" column.
     *
     * @return string
     */
    public function getQualifiedVersionedAtColumn()
    {
        return $this->qualifyColumn($this->getVersionedAtColumn());
    }
}
