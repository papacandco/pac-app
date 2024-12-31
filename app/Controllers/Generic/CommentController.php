<?php

namespace App\Controllers\Generic;

use App\Controllers\Controller;
use App\Controllers\Traits\ApiResponseTrait;
use App\Models\Comment;
use Bow\Http\Request;

class CommentController extends Controller
{
    use ApiResponseTrait;

    /**
     * List of commentable
     *
     * @var array
     */
    private $commentables = [
        'tutorial' => \App\Models\Tutorial::class,
        'challenge' => \App\Models\Challenge::class,
        'question' => \App\Models\Question::class,
        'podcast' => \App\Models\Podcast::class,
    ];

    /**
     * CommentController constructor.
     */
    public function __construct(
        private Comment $comment
    ) {
    }

    /**
     * Get the comment
     *
     * @return mixed
     */
    public function show(
        Request $request,
        $type,
        $commentable_id
    ) {
        if (! array_key_exists($type, $this->commentables)) {
            return redirect()
                ->back()
                ->withFlash('error', __('controller.comment.create.error'));
        }

        $model = new $this->commentables[$type]();

        $commentable = $model->find($commentable_id);

        $comments = $commentable->comments()
            ->orderBy('created_at', 'desc')
            ->where('parent_id', 0)->get();

        foreach ($comments as $comment) {
            $this->loadRecurvise($comment->comments);
        }

        return $comments;
    }

    /**
     * Get comment
     *
     * @return mixed
     */
    public function showComment(Request $request, int $comment_id)
    {
        $user = $request->user();

        $comment = $this->comment->where('user_id', $user->id)->where('id', $comment_id)->first();

        if (is_null($comment)) {
            return $this->formatErrorResponse();
        }

        return $this->formatSuccessResponse($comment->toArray());
    }

    /**
     * Load the comment recurvisly
     *
     * @param  array $comments
     * @return void
     */
    protected function loadRecurvise($comments)
    {
        foreach ($comments ?? [] as $comment) {
            if ($comment->comments) {
                $this->loadRecurvise($comment->comment);
            }
        }
    }

    /**
     * Create a new comment
     *
     * @param  string $type
     * @param  int    $commentable_id
     * @return mixed
     */
    public function create(Request $request, $type, $commentable_id)
    {
        if (! array_key_exists($type, $this->commentables)) {
            return redirect()
                ->back()
                ->withFlash('error', __('controller.comment.create.error'));
        }

        $model = new $this->commentables[$type]();

        $commentable = $model->find($commentable_id);

        if (auth()->guest()) {
            $validation = validator($request->all(), [
                'email' => 'required|email',
                'name' => 'required',
                'content' => 'required|max:2000',
            ]);
        } else {
            $validation = validator($request->all(), [
                'content' => 'required|max:2000',
            ]);
        }

        if ($validation->fails()) {
            return redirect()
                ->back()
                ->withFlash('warning', __('controller.comment.create.warning'));
        }

        // Create the user type
        $data = $this->createUserType($request);

        $data['content'] = $request->get('content');
        $data['parent_id'] = (int) $request->get('comment_id');
        $data['commentable_type'] = get_class($model);
        $data['commentable_id'] = $model->id;

        // Create the comment
        $comment = $commentable->comments()->create($data);
        $comment->notifiyParentAuthor();

        return redirect()
            ->back()
            ->withFlash('success', __('controller.comment.create.success'));
    }

    /**
     * Update user comment
     *
     * @return mixed
     */
    public function update(Request $request, $comment_id)
    {
        $comment = $this->comment->find($comment_id);

        if ($request->user()->id != $comment->user_id) {
            return redirect()
                ->back()
                ->withFlash('error', __('controller.comment.update.error'));
        }

        // Update comment
        $comment->content = $request->get('content');
        $comment->touch();

        return redirect()
            ->back()
            ->withFlash('success', __('controller.comment.update.success'));
    }

    /**
     * Create the user type
     *
     * @param  Request $request
     * @return array
     */
    private function createUserType($request)
    {
        $data = [];

        $data['user_id'] = $request->user()->id;
        $data['user_type'] = \App\Models\User::class;

        return $data;
    }
}
