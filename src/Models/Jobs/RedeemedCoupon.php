<?php

namespace OmniaDigital\CatalystCore\Models\Jobs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RedeemedCoupon extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'coupon_id',
        'code',
        'type',
        'original_price',
        'discount_amount',
        'after_discount_price',
        'redeemed_at',
    ];

    protected $casts = [
        'redeemed_at' => 'datetime',
    ];

    public function model()
    {
        return $this->morphTo();
    }

    /**
     * @return BelongsTo
     */
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
}
