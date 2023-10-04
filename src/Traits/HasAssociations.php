<?php

namespace OmniaDigital\CatalystCore\Traits;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use OmniaDigital\CatalystCore\Models\Association;

trait HasAssociations
{
    /**
     * @return MorphToMany
     */
    public function associations()
    {
        return $this->morphTo(Association::class, 'associatable');
    }
}
