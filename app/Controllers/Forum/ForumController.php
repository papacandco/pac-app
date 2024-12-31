<?php

namespace App\Controllers\Forum;

use App\Controllers\Controller;
use App\Controllers\Traits\ForumTrait;
use App\Controllers\Traits\TaggableTrait;
use App\Producers\NotificationCurriculumFollowersForTheQuestionCreationProducer;
use App\Models\Comment;
use App\Models\Curriculum;
use App\Models\Question;
use App\Models\Technology;
use Bow\Http\Request;

class ForumController extends Controller
{
    use ForumTrait;
    use TaggableTrait;

    /**
     * Number of element per page
     *
     * @var int
     */
    public const PER_PAGE = 10;

    /**
     * ForumController constructor.
     */
    public function __construct(
        private Technology $technologie,
        private Curriculum $curriculum,
        private Question $question,
        private Comment $comment
    ) {
    }

    /**
     * Show the Technology list
     *
     * @param  Question $question
     * @param  Comment  $comment
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        $num_of_question = $this->question->count();

        $num_of_response = $this->comment
            ->where('commentable_type', Question::class)
            ->count();

        $questions = $this->question->orderBy('created_at', 'desc')->paginate(static::PER_PAGE);

        return view('forum.index', compact('num_of_question', 'num_of_response', 'questions'));
    }

    /**
     * Show the Technology question
     *
     * @return mixed
     */
    public function showCurriculum(Request $request, string $slug, int $curriculum_id)
    {
        $curriculum = $this->curriculum->find($curriculum_id);

        $questions = $curriculum->questions()->paginate(static::PER_PAGE);

        return view('forum.index', compact('curriculum', 'questions'));
    }

    /**
     * Show the writer form
     *
     * @return mixed
     */
    public function showWriterForm(Request $request)
    {
        $data = [];

        if ($request->has('curriculum_id')) {
            $data['curriculum'] = $this->curriculum->find((int) $request->get('curriculum_id'));
        }

        return view('forum.writer', $data);
    }

    /**
     * Create the question on general form or specifique form
     *
     * @return mixed
     */
    public function createQuestion(
        Request $request,
        ?int $curriculum_id = null
    ) {
        if (! ($request->has('content') && $request->has('title'))) {
            return redirect()
                ->back()
                ->withFlash('error', __('forum.can-not-post-empty-message'));
        }

        $slug = str_slug($request->get('title'));
        $question = $this->question->where('slug', $slug)->first();

        if ($question) {
            $route = route('forum.question', ['slug' => $question->slug, 'id' => $question->id]);

            return redirect()
                ->back()
                ->withFlash('warning', __('forum.question-exists', ['route' => $route, 'title' => $question->title]));
        }

        $user = $request->user();
        $curriculum = null;

        // Check if curriculum is especified and exist
        if (! is_null($curriculum_id)) {
            $curriculum = $this->curriculum->find($curriculum_id);

            if (is_null($curriculum)) {
                return app_abort(404);
            }
        }

        // Create the new question
        $question = $this->question->create([
            'slug' => str_slug($request->get('title')),
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'curriculum_id' => (int) $curriculum_id,
            'user_id' => $user->id,
            'user_type' => get_class($user),
        ]);

        // Associate tag to question
        $this->createTags($question, (array) $request->get('tags_id'));

        if (! is_null($curriculum)) {
            // Notify all curriculum follower that user have sent a new question
            queue(
                new NotificationCurriculumFollowersForTheQuestionCreationProducer(
                    $curriculum,
                    $question
                )
            );
        }

        // Get the question route
        $route = route('forum.question', [
            'slug' => $this->question->slug,
            'id' => $this->question->id,
        ]);

        return redirect()
            ->back()
            ->withFlash('success', __('forum.question-posted', compact('roure')));
    }
}
