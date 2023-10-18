<?php

namespace OmniaDigital\CatalystSocialPlugin\Models;

use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class FeedCategories extends Model
{
    use Sushi;

    protected $rows = [
        [
            'id' => 0,
            'name' => 'my-feed',
            'label' => 'My Feed',
        ],
        [
            'id' => 1,
            'name' => 'top-teams',
            'label' => 'Top Teams',
        ],
        [
            'id' => 2,
            'name' => 'newest',
            'label' => 'Newest',
        ],
        [
            'id' => 3,
            'name' => 'favorites',
            'label' => 'Favorites',
        ],
        [
            'id' => 4,
            'name' => 'undiscovered',
            'label' => 'Undiscovered',
        ],
    ];
}
