<?php

namespace App\Notifications;

use App\Models\Curriculum;
use App\Models\Question;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CurriculumQuestionCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        private Curriculum $curriculum,
        private Question $question
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

        if (! is_null($notifiable->email) && ! preg_match("/.*_stub_email@codelearningclub\.com/", $notifiable->email)) {
            $via[] = 'mail';
        }

        return $via;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(mixed $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('mail.question.subject', [
                'name' => $notifiable->name,
                'title' => $this->question->title,
            ]))
            ->view('mail.curriculum-new-question', [
                'curriculum' => $this->curriculum,
                'question' => $this->question,
                'user' => $notifiable,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $title = $this->question->title;
        $name = $notifiable->name;

        $route = route('forum.question', [
            'slug' => $this->question->slug,
            'id' => $this->question->id,
        ]);

        return [
            'type' => 'curriculum-new-question',
            'message' => "Nouvelle question de $name, <a href=\"$route\">$title</a>",
        ];
    }
}
