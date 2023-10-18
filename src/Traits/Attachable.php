<?php

namespace OmniaDigital\CatalystCore\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Attachable
{
    /**
     * Get the model's attachments
     */
    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}
