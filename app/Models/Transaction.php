<?php

namespace App\Models;

use Bow\Database\Barry\Model;
use Bow\Database\Barry\Relations\BelongsTo;

class Transaction extends Model
{
    /**
     * Hidden field
     *
     * @var array
     */
    protected array $hidden = ['updated_at', 'created_at'];

    /**
     * Define the primary key type
     *
     * @var string
     */
    protected string $keyType = 'string';

    /**
     * Transaction constructor
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        Transaction::updating(function (Transaction $transaction) {
            $transaction->extras = json_encode($transaction->extras);
        });
    }

    /**
     * Check the transaction has failed
     *
     * @return bool
     */
    public function isFailed()
    {
        return $this->status === 'failed';
    }

    /**
     * Check the transaction has success
     *
     * @return bool
     */
    public function isSuccess()
    {
        return $this->status === 'success';
    }

    /**
     * Check the transaction has pending
     *
     * @return bool
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Mutate the extras attribute
     *
     * @return mixed
     */
    public function getExtrasAttribute(string $value)
    {
        return json_decode($value);
    }

    /**
     * Get the related user
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the related user
     *
     * @return mixed
     */
    public function target()
    {
        return $this->belongsTo($this->target_type, $this->target_id);
    }

    /**
     * Get the type as humain
     *
     * @return string
     */
    public function getLabelAttribute(): string
    {
        if ($this->target_type == Tutorial::class) {
            return 'Achat de tutoriel';
        }

        if ($this->target_type == Curriculum::class) {
            return 'Achat de formation';
        }

        if ($this->target_type == Podcast::class) {
            return 'Achat de podcast';
        }

        if ($this->target_type == Product::class) {
            return 'Souscription ' . $this->target->title;
        }

        return ucfirst($this->type);
    }
}
