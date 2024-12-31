<?php

namespace App\Events;

use App\Models\Transaction;
use Bow\Event\Contracts\AppEvent;
use Bow\Event\Dispatchable;
use Bow\Support\Serializes;

class PaymentSuccessfulEvent implements AppEvent
{
	use Dispatchable, Serializes;

    /**
     * Create a new event instance.
     */
    public function __construct(private Transaction $transaction)
    {
        // Do something here
    }
}
