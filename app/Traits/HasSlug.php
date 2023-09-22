<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    /**
     * Boot HasSlug trait
     */
    protected static function bootHasSlug(): void
    {
        static::creating(function ($model) {
            $model->slug = $model->generateSlug();
        });

        static::updating(function ($model) {
            if ($model->isDirty('title')) {
                $model->slug = $model->generateSlug();
            }
        });
    }

    /**
     * Generate a unique slug for this model
     * @return string
     */
    protected function generateSlug(): string
    {
        $slug = Str::slug($this->title);

        $originalSlug = $slug; 

        $latestSlug =
            static::where('slug', $slug)
            ->latest('id')
            ->value('slug');

        if ($latestSlug) {
            $slug .= '-' . mt_rand(1, 9999);

            while (static::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . mt_rand(1, 9999);
            }
        }

        return $slug;
    }
}
