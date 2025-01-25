<?php

namespace App\Messages;

use App\Models\Transaction;
use Bow\Database\Barry\Model;
use Bow\Mail\Message;
use Bow\Messaging\Messaging;

class DonationSuccessMessage extends Messaging
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

    public function toMail(Model $notifiable): ?Message
    {
        $mail = (new Message())->view('mail.donation.success', [
            'transaction' => $this->transaction,
            'name' => $notifiable->name,
        ]);

        return $mail->subject('Don de ' . $this->transaction->amount . ' ' . $this->transaction->extras->currency . ' réussit 😍');
    }

    /**
     * Get the array representation of the message.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase(Model $notifiable): array
    {
        return [
            'type' => 'donation_success',
            'message' => sprintf(
                'Merci pour votre don de %s %s à Papac & Co 😍',
                $this->transaction->amount,
                $this->transaction->extras->currency
            ),
        ];
    }
}
