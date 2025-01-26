<?php

namespace App\Producers;

use App\Messages\AnswerToTheAuthorOfTheQuestionMessage;
use App\Messages\AnswerToTheFollowerOfTheQuestionMessage;
use App\Models\Comment;
use App\Models\Question;
use Bow\Queue\ProducerService;

class AnswerOfTheQuestionProducer extends ProducerService
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
            $this->question->author->sendMessage(
                new AnswerToTheAuthorOfTheQuestionMessage($this->question, $this->comment)
            );
        }

        $bookmarks = $this->question->bookmarks()->withFlash('user')->get();

        foreach ($bookmarks as $bookmark) {
            if ($this->comment->user_id != $bookmark->user_id) {
                $message = new AnswerToTheFollowerOfTheQuestionMessage($this->question, $this->comment, $bookmark);
                $bookmark->user->sendMessage($message);
            }
        }
    }
}
