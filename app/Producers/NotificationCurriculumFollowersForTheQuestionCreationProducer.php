<?php

namespace App\Producers;

use App\Models\Curriculum;
use App\Models\Question;
use App\Notifications\CurriculumQuestionCreatedNotification;
use Bow\Queue\ProducerService;

class NotificationCurriculumFollowersForTheQuestionCreationProducer extends ProducerService
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private Curriculum $curriculum,
        private Question $question
    ) {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function process(): void
    {
        foreach ($this->curriculum->followers as $follower) {
            $follower->user->notify(
                new CurriculumQuestionCreatedNotification(
                    $this->curriculum,
                    $this->question
                )
            );
        }
    }
}
