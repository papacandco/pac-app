<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReplyCommentNotification extends Notification
{
    use Queueable;

    /**
     * Define instance of Comment
     *
     * @var Comment
     */
    private $parent;

    /**
     * Define instance of Comment
     *
     * @var Comment
     */
    private $comment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Comment $parent, Comment $comment)
    {
        $this->parent = $parent;
        $this->comment = $comment;

        $this->onQueue('mailing');
    }

    /**
     * Get the notification's dechallengery channels.
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
            ->subject(__('mail.comment.subject', ['name' => $this->comment->user->name]))
            ->view('mail.reply-comment', ['comment' => $this->comment, 'parent' => $this->parent]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'type' => 'comment',
            'message' => "{$this->comment->user->name} a répondu votre commentaire <b>{$this->comment->content}</b>",
        ];
    }
}
