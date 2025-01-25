<?php

namespace App\Events;

use App\Models\Transaction;
use App\Models\User;
use Bow\Event\Contracts\AppEvent;
use Bow\Event\Dispatchable;
use Bow\Support\Serializes;

class DonationSuccessfulEvent implements AppEvent
{
    use Dispatchable;
    use Serializes;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(
        private Transaction $transaction
    ) {
    }
}
