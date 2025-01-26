<?php

namespace App\Producers;

use App\Messages\CurriculumQuestionCreatedMessage;
use App\Models\Curriculum;
use App\Models\Question;
use Bow\Queue\ProducerService;

class CurriculumFollowersForTheQuestionCreationProducer extends ProducerService
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
            $follower->user->sendMessage(
                new CurriculumQuestionCreatedMessage(
                    $this->curriculum,
                    $this->question
                )
            );
        }
    }
}
