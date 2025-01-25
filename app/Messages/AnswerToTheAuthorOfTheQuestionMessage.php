<?php

namespace App\Messages;

use Bow\Mail\Message;
use Bow\Messaging\Messaging;
use Bow\Database\Barry\Model;

class AnswerToTheAuthorOfTheQuestionMessage extends Messaging
{
    /**
     * Get the channels the message should be sent on.
     *
     * @return array
     */
    public function channels(Model $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Send message to mail
     *
     * @param Model $notifiable
     * @return Message|null
     */
    public function toMail(Model $notifiable): ?Message
    {
        return new Message();
    }

    /**
     * Send message to database
     *
     * @param Model $notifiable
     * @return array
     */
    public function toDatabase(Model $notifiable): array
    {
        return [];
    }
}
