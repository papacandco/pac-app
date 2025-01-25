<?php

namespace App\Messages;

use App\Models\Comment;
use Bow\Database\Barry\Model;
use Bow\Mail\Message;
use Bow\Messaging\Messaging;

class ReplyCommentMessage extends Messaging
{
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
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Comment $parent, Comment $comment)
    {
        $this->parent = $parent;
        $this->comment = $comment;
    }

    /**
     * Get the message's dechallengery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function channels(Model $notifiable): array
    {
        $via = ['database'];

        if (! is_null($notifiable->email) && ! preg_match("/.*_stub_email\@codelearningclub\.com/", $notifiable->email)) {
            $via[] = 'mail';
        }

        return $via;
    }

    /**
     * Get the mail representation of the message.
     *
     * @param  Model  $notifiable
     * @return Message
     */
    public function toMail(Model $notifiable): Message
    {
        return (new Message())
            ->subject(__('mail.comment.subject', ['name' => $this->comment->user->name]))
            ->view('mail.reply-comment', ['comment' => $this->comment, 'parent' => $this->parent]);
    }

    /**
     * Get the array representation of the message.
     *
     * @param  Model  $notifiable
     * @return array
     */
    public function toDatabase(Model $notifiable): array
    {
        return [
            'type' => 'comment',
            'message' => "{$this->comment->user->name} a répondu votre commentaire <b>{$this->comment->content}</b>",
        ];
    }
}
