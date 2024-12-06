<?php

namespace App\Jobs;

use App\Models\Curriculum;
use App\Models\Question;
use App\Notifications\CurriculumQuestionCreatedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotificationCurriculumFollowersForTheQuestionCreationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private Curriculum $curriculum,
        private Question $question
    ) {}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->curriculum->followers as $follower) {
            $follower->user->notify(new CurriculumQuestionCreatedNotification(
                $this->curriculum,
                $this->question
            ));
        }
    }
}
