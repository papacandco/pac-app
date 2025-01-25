<?php

namespace App\Controllers\Forum;

use App\Controllers\Controller;
use App\Controllers\Traits\ForumTrait;
use App\Controllers\Traits\TaggableTrait;
use App\Models\Question;
use App\Producers\AnswerOfTheQuestionMessageProducer;
use Bow\Http\Request;

class QuestionController extends Controller
{
    use ForumTrait;
    use TaggableTrait;

    /**
     * Number of element per page
     *
     * @var int
     */
    public const PER_PAGE = 25;

    /**
     * Define Technology instance
     *
     * @var Question
     */
    private $question;

    /**
     * ForumController constructor.
     */
    public function __construct(Question $question)
    {
        $this->question = $question;
    }

    /**
     * Show theTechnology question comments
     *
     * @return mixed
     */
    public function __invoke(Request $request, string $slug, int $question_id)
    {
        $question = $this->question->where('slug', $slug)->where('id', $question_id)->first();

        if (!$question) {
            return app_abort(404);
        }

        $curriculum = false;

        if ($question->hasCurriculum()) {
            $curriculum = $question->curriculum;
        }

        return view('forum.question', compact('curriculum', 'question'));
    }

    /**
     * Show theTechnology question comments
     *
     * @param  int $question_id
     * @return mixed
     */
    public function showUpdateQuestion(Request $request, string $slug, string $question_id)
    {
        $question = $this->question->where('slug', $slug)->where('id', $question_id)->first();
        $user = $request->user();

        if ($question->user_id != $user->id) {
            return redirect()
                ->route('form.question', ['slug' => $question->slug, 'id' => $question->id])
                ->back();
        }

        if ($question->hasCurriculum()) {
            $curriculum = $question->curriculum;
        }

        $tags = $question->technologies()->pluck('id')->toArray();

        // Get the contributor
        $contributors = $question->comments->unique('user_id');

        return view('forum.update-writer', compact('question', 'contributors', 'tags'));
    }

    /**
     * Update the new question
     *
     * @return mixed
     */
    public function updateQuestion(
        Request $request,
        string $slug,
        int $question_id
    ) {
        if (! ($request->has('content') && $request->has('title'))) {
            return redirect()
                ->back()
                ->withFlash('error', __('forum.can-not-post-empty-message'));
        }

        $question = $this->question->where('slug', $slug)->where('id', '!=', $question_id)->first();

        if ($question) {
            $route = route('forum.question', ['slug' => $question->slug, 'id' => $question->id]);

            return redirect()
                ->back()
                ->withFlash('warning', __('forum.question-exists', ['route' => $route, 'title' => $question->title]));
        }

        $user = $request->user();
        $question = $this->question->whereId($question_id)->first();

        if ($question->user_id != $user->id) {
            return redirect()
                ->back()
                ->withFlash('warning', 'Vous ne pouvez pas modifier cette question');
        }

        $question->setAttributes([
            'slug' => $slug,
            'title' => $request->get('title'),
            'content' => $request->get('content'),
        ]);

        $question->touch();
        $question->taggables()->delete();

        // Associate tag to question
        $this->createTags($question, (array) $request->get('tags_id'));

        return redirect()
            ->back()
            ->withFlash('success', 'Question mise à jour !');
    }

    /**
     * Add response to the question
     *
     * @return mixed
     */
    public function createResponse(Request $request, int $question_id)
    {
        $question = $this->question->find($question_id);

        if (! $question) {
            return redirect()
                ->route('forum')
                ->withFlash('success', "La question ciblé n'a pas été trouvé");
        }

        $content = $request->get('content');

        if (is_null($content)) {
            return redirect()
                ->route('forum.question', ['slug' => $question->slug, 'id' => $question->id])
                ->withFlash('danger', "Le contenu est vide.");
        }

        $user = $request->user();

        $comment = $question->comments()->create([
            'content' => $content,
            'user_id' => $user->id,
            'user_type' => get_class($user),
            'commentable_id' => $question->id,
            'commentable_type' => get_class($question),
        ]);

        queue(new AnswerOfTheQuestionMessageProducer($question, $comment));

        return redirect()
            ->back()
            ->withFlash('success', __('forum.response-posted'));
    }

    /**
     * Add response to the question
     *
     * @return mixed
     */
    public function deleteQuestion(Request $request)
    {
        $user = $request->user();
        $question = $this->question->whereId((int) $request->get('question_id'))->whereUserId($user->id)->first();

        if (! $question) {
            return redirect()
                ->route('forum')
                ->withFlash('success', "La question ciblé n'a pas été trouvé");
        }

        $question->delete();

        return redirect()
            ->route('forum')
            ->withFlash('success', 'La question a été supprimé !');
    }
}
