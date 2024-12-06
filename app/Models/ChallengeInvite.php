<?php

namespace App\Models;

use Bow\Database\Barry\Model;
use Bow\Database\Barry\Relations\BelongsTo;

class ChallengeInvite extends Model
{
    /**
     * Get the guest information
     * Note: The guest is a system user
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * Get the challenge information
     *
     * @return BelongsTo;
     */
    public function challenge()
    {
        return $this->belongsTo(Challenge::class, 'challenge_id');
    }

    /**
     * Check if the invitation already userd
     *
     * @return bool
     */
    public function isAlreadyUsed()
    {
        return $this->status == 1;
    }
}
