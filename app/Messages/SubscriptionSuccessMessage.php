<?php

namespace App\Messages;

use Bow\Mail\Message;
use App\Models\Transaction;
use Bow\Messaging\Messaging;
use Bow\Database\Barry\Model;

class SubscriptionSuccessMessage extends Messaging
{
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        private Transaction $transaction
    ) {
    }

    /**
     * Get the message's dechallengery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function channels(Model $notifiable): array
    {
        $via = ['database'];

        if (! is_null($notifiable->email) && ! preg_match("/.*_stub_email\@codelearningclub\.com/", $notifiable->email)) {
            $via[] = 'mail';
        }

        return $via;
    }

    /**
     * Get the mail representation of the message.
     *
     * @param  Model  $notifiable
     * @return Message
     */
    public function toMail(Model $notifiable): ?Message
    {
        $mail = (new Message())->view('mail.subscription.success', [
            'transaction' => $this->transaction,
            'name' => $notifiable->name,
        ]);

        return $mail->subject('Confirmation de souscription à ' . $this->transaction->target->title . ' 😍');
    }

    /**
     * Get the array representation of the message.
     *
     * @param  Model  $notifiable
     * @return array
     */
    public function toDatabase(Model $notifiable): array
    {
        return [
            'type' => 'subscription_success',
            'message' => sprintf(
                'Votre souscription %s de %s %s a été validé 😍',
                $this->transaction->target->title,
                $this->transaction->amount,
                $this->transaction->extras?->currency ?? 'XOF'
            ),
        ];
    }
}
