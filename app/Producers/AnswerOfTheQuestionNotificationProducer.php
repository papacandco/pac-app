<?php

namespace App\Producers;

use App\Models\Comment;
use App\Models\Question;
use App\Notifications\AnswerToTheAuthorOfTheQuestionNotification;
use App\Notifications\AnswerToTheFollowerOfTheQuestionNotification;
use Bow\Queue\ProducerService;

class AnswerOfTheQuestionNotificationProducer extends ProducerService
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private Question $question,
        private Comment $comment,
    ) {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function process(): void
    {
        if ($this->question->user_id !== $this->comment->user_id) {
            $this->question->author->notify(
                new AnswerToTheAuthorOfTheQuestionNotification($this->question, $this->comment)
            );
        }

        $bookmarks = $this->question->bookmarks()->withFlash('user')->get();

        foreach ($bookmarks as $bookmark) {
            if ($this->comment->user_id != $bookmark->user_id) {
                $notification = new AnswerToTheFollowerOfTheQuestionNotification($this->question, $this->comment, $bookmark);
                $bookmark->user->notify($notification);
            }
        }
    }
}
