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
    ) {}

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

        $model = new $this->commentables[$type];

        $commentable = $model->findOrFail($commentable_id);

        $comments = $commentable->comments()
            ->orderBy('created_at', 'desc')
            ->where('parent_id', 0)->get();

        $comments->load(['user', 'comments' => function ($query) {
            return $query
                ->orderBy('created_at', 'desc');
        }]);

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

        $comment = $this->comment->whereUserId($user->id)->whereId($comment_id)->first();

        if (is_null($comment)) {
            return $this->formatErrorResponse();
        }

        return $this->formatSuccessResponse($comment->toArray());
    }

    /**
     * Load the comment recurvisly
     *
     * @param  array  $comments
     * @return void
     */
    protected function loadRecurvise($comments)
    {
        foreach ($comments ?? [] as $comment) {
            $comment->load(['user', 'comments' => function ($query) {
                return $query
                    ->orderBy('created_at', 'desc');
            }]);

            if ($comment->comments) {
                $this->loadRecurvise($comment->comment);
            }
        }
    }

    /**
     * Create a new comment
     *
     * @param  string  $type
     * @param  int  $commentable_id
     * @return mixed
     */
    public function create(Request $request, $type, $commentable_id)
    {
        if (! array_key_exists($type, $this->commentables)) {
            return redirect()
                ->back()
                ->withFlash('error', __('controller.comment.create.error'));
        }

        $model = new $this->commentables[$type];

        $commentable = $model->findOrFail($commentable_id);

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
        $comment = $this->comment->findOrFail($comment_id);

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
     * @param  Request  $request
     * @return array
     */
    private function createUserType($request)
    {
        $data = [];

        if (! is_null($request->user())) {
            $data['user_id'] = $request->user()->id;
            $data['user_type'] = \App\Models\User::class;

            return $data;
        }

        if ($request->session()->exists('auth')) {
            $config = \App\Models\Configuration::first();
            $data['user_id'] = $config->email;
            $data['user_type'] = \App\Models\Configuration::class;

            return $data;
        }

        $anonymous = \App\Models\Anonymous::create([
            'email' => $request->get('email'),
            'name' => $request->get('name'),
        ]);

        $data['user_id'] = $anonymous->id;
        $data['user_type'] = get_class($anonymous);

        // Add request source
        $data['source_ip'] = $request->ip();
        $data['source_client'] = $request->getHeader('user-agent');
        $data['source_referer'] = $request->getHeader('referer');

        return $data;
    }
}
