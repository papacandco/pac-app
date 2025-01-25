<?php

namespace App\Messages;

use Bow\Mail\Message;
use Bow\Messaging\Messaging;

class WelcomeMessage implements Messaging
{
    /**
     * Get the message's dechallengery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $via = [];

        if (! is_null($notifiable->email) && ! preg_match("/.*_stub_email\@codelearningclub\.com/", $notifiable->email)) {
            $via[] = 'mail';
        }

        return $via;
    }

    /**
     * Get the mail representation of the message.
     *
     * @param  mixed  $notifiable
     * @return Message
     */
    public function toMail($notifiable)
    {
        $message = new Message();

        return $message
            ->subject(__('mail.welcome.subject'))
            ->view('mail.welcome', ['name' => $notifiable->name]);
    }
}
