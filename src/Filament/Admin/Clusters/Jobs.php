<?php

namespace OmniaDigital\CatalystCore\Filament\Admin\Clusters;

use Filament\Clusters\Cluster;
use Filament\Support\Enums\MaxWidth;

class Jobs extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    public function getMaxContentWidth(): MaxWidth
    {
        return MaxWidth::Full;
    }
}
