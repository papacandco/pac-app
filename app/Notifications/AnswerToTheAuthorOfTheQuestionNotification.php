<?php

namespace App\Notifications;

use App\Models\Comment;
use App\Models\Question;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AnswerToTheAuthorOfTheQuestionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        private Question $question,
        private Comment $comment
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
        return (new MailMessage)
            ->subject(__('mail.question.subject', [
                'name' => $this->comment->user->name,
                'title' => $this->question->title,
            ]))
            ->view('mail.question-answer', [
                'comment' => $this->comment,
                'question' => $this->question,
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
        $question = $this->question;
        $comment = $this->comment;

        $route = route('forum.question', [
            'slug' => $this->question->slug,
            'id' => $this->question->id,
        ]);

        return [
            'type' => 'question-answer',
            'message' => "{$comment->user->name} a répondu à votre question <a href={$route}><b>{$question->title}</b></a>",
        ];
    }
}
