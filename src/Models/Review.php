<?php

namespace OmniaDigital\CatalystCore\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OmniaDigital\CatalystCore\Traits\Likable;
use OmniaDigital\CatalystCore\Traits\Postable;
use OmniaDigital\CatalystReviewsPlugin\Models\Review as BaseReview;

class Review extends BaseReview
{
    use Postable, Likable;

    protected $casts = [
        'commentable' => 'boolean',
    ];

    public function language(): ?BelongsTo
    {
        if (!class_exists(Language::class)) {
            return null;
        }
        return $this->belongsTo(Language::class);
    }

}
