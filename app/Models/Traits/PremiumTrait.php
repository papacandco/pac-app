<?php

namespace App\Models\Traits;

use App\Models\Purchase;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait PremiumTrait
{
    /**
     * Determine if user is premium
     *
     * @return bool
     */
    public function isPremium()
    {
        return $this->premium === 1;
    }

    /**
     * Determine if tutorial is paying
     *
     * @return bool
     */
    public function isOneTimePayment()
    {
        return $this->one_time == 1;
    }

    /**
     * Change the premium status
     *
     * @return bool
     */
    public function togglePremium()
    {
        $this->premium = ! $this->premium;

        $this->save();

        return $this->save();
    }

    /**
     * Get all purchases associates to the element
     *
     * @return MorphMany
     */
    public function purchases()
    {
        return $this->morphMany(Purchase::class, 'purchaseable');
    }
}
