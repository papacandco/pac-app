<?php

namespace App\Messages;

use Bow\Mail\Message;
use App\Models\Transaction;
use Bow\Messaging\Messaging;
use Bow\Database\Barry\Model;
use Illuminate\Messages\Messages\MailMessage;

class DonationFailedMessage implements Messaging
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
    public function via($notifiable)
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
        $mail = (new Message())->view('mail.donation.failed', [
            'transaction' => $this->transaction,
            'name' => $notifiable->name,
        ]);

        return $mail->subject('Don de ' . $this->transaction->amount . ' ' . $this->transaction->extras->currency . ' a échoué 😢');
    }

    /**
     * Get the array representation of the message.
     *
     * @param  Model  $notifiable
     * @return array
     */
    public function toDatabase(Model $notifiable)
    {
        return [
            'type' => 'donation_failed',
            'message' => sprintf(
                'Votre don de %s%s a échoué 😢',
                $this->transaction->amount,
                $this->transaction->extras->currency
            ),
        ];
    }
}
