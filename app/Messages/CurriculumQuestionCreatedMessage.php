<?php

namespace App\Messages;

use Bow\Mail\Message;
use Bow\Messaging\Messaging;
use Bow\Database\Barry\Model;

class CurriculumQuestionCreatedMessage extends Messaging
{
    public function __construct(
        private Model $curriculum,
        private Model $question
    ) {
    }

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
        return (new Message())->subject(__('mail.question.subject', [
            'name' => $notifiable->name,
            'title' => $this->question->title,
        ]))
            ->view('mail.curriculum-new-question', [
                'curriculum' => $this->curriculum,
                'question' => $this->question,
                'user' => $notifiable,
            ]);
        ;
    }

    /**
     * Send message to database
     *
     * @param Model $notifiable
     * @return array
     */
    public function toDatabase(Model $notifiable): array
    {
        return [
            'title' => 'Answer to the question',
            'message' => 'A new answer has been posted to the question you follow',
            'link' => 'http://example.com/question/1',
        ];
    }
}
