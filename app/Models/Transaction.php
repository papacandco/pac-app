<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Bow\Database\Barry\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The fillable data
     *
     * @var array
     */
    protected $fillable = [
        'id', 'amount', 'status', 'provider', 'type', 'target_id', 'target_type', 'user_id', 'user_type', 'extras',
    ];

    /**
     * Hidden field
     *
     * @var array
     */
    protected $hidden = ['updated_at', 'created_at'];

    /**
     * Define the primary key type
     *
     * @var bool
     */
    protected $keyType = 'string';

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
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the related user
     *
     * @return MorphTo
     */
    public function target()
    {
        return $this->morphTo();
    }

    /**
     * Get the type as humain
     *
     * @return string
     */
    public function getLabelAttribute()
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
            return 'Souscription '.$this->target->title;
        }

        return ucfirst($this->type);
    }
}
