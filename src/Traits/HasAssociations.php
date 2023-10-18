<?php

namespace OmniaDigital\CatalystSocialPlugin\Traits;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use OmniaDigital\CatalystSocialPlugin\Models\Association;

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
