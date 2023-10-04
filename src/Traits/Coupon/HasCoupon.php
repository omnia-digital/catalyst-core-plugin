<?php

namespace App\Traits\Coupon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use LogicException;
use Modules\Jobs\Models\Coupon;
use Modules\Jobs\Models\RedeemedCoupon;

trait HasCoupon
{
    /**
     * Redeem a coupon.
     *
     * @return Model
     */
    public function redeemCoupon($coupon, $originalPrice)
    {
        $coupon = $coupon instanceof Coupon ? $coupon : Coupon::findByCode($coupon);

        if (! $coupon) {
            throw new LogicException('Coupon is not found');
        }

        return $this->redeemedCoupon()->create([
            'coupon_id' => $coupon->id,
            'code' => $coupon->code,
            'type' => $coupon->type,
            'original_price' => $originalPrice,
            'discount_amount' => $coupon->discountAmount($originalPrice),
            'after_discount_price' => $coupon->afterDiscount($originalPrice),
            'redeemed_at' => now(),
        ]);
    }

    /**
     * @return MorphOne
     */
    public function redeemedCoupon()
    {
        return $this->morphOne(RedeemedCoupon::class, 'model');
    }
}
