<?php

namespace App\Notifications;

use App\Models\Podcast;
use App\Models\Transaction;
use App\Models\Tutorial;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ElementPaymentSuccessNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        private Transaction $transaction
    ) {
        $this->onQueue('mailing');
    }

    /**
     * Get the notification's delivery channels.
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
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $mail = (new MailMessage)->view('mail.payment.success', [
            'transaction' => $this->transaction,
            'name' => $notifiable->name,
        ]);

        return $mail->subject('Papac & Co: Confirmation de paiement pour '.$this->transaction->target->title.' 😍');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $target = $this->transaction->target;

        if ($target instanceof Tutorial) {
            $route = route('tutorial.reader', [
                'slug' => $target->slug,
                'id' => $target->id,
            ]);

            return [
                'type' => 'payement_success',
                'message' => sprintf('Votre paiement de <b>{%s}</b> pour le tutoriel <a href="%s">%s</a> a été validé 😍', $this->transaction->amount, $route, $target->title),
            ];
        }

        if ($target instanceof Podcast) {
            $route = route('podcast.single', [
                'slug' => $target->slug,
                'id' => $target->id,
            ]);

            return [
                'type' => 'payement_success',
                'message' => sprintf('Votre paiement de <b>{%s}</b> pour le podcast <a href="%s">%s</a> a été validé 😍', $this->transaction->amount),
            ];
        }

        $route = route('curriculum.single', [
            'slug' => $target->slug,
        ]);

        return [
            'type' => 'payement_success',
            'message' => sprintf('Votre paiement de <b>{%s}</b> pour la formation <a href="%s">%s</a> a été validé 😍', $this->transaction->amount, $route, $target->title),
        ];
    }
}
