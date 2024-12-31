<?php

namespace App\Controllers\Generic;

use Bow\Support\Log;
use Bow\Http\Request;
use App\Models\Podcast;
use App\Models\Question;
use App\Models\Tutorial;
use App\Models\Curriculum;
use App\Models\Technology;
use App\Controllers\Controller;

class SearchController extends Controller
{
    /**
     * SearchController constructor
     */
    public function __construct(
        private Tutorial $tutorial,
        private Podcast $podcast,
        private Technology $technologie,
        private Question $question,
        private Curriculum $curriculum
    ) {
    }

    /**
     * Show Search result
     *
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        $query = trim(addslashes($request->get('q', '')));

        if (strlen($query) == 0) {
            return app_abort(404);
        }

        $author = $request->get('author');
        $filter = $request->get('filter', 'tutorial');

        if (!in_array($filter, ['formation', 'podcast', 'tutorial', 'question'])) {
            return app_abort(404);
        }

        Log::info('information recherchez: ' . $query);

        $raw = "%$query%";

        if ($filter === 'tutorial') {
            $query_builder = $this->tutorial
                ->where('published', true)
                ->where('title', 'like', $raw);

            if (! is_null($author)) {
                $tutorials = $query_builder->where('author_Id', (int) $author);
            }

            $tutorials = $query_builder->get();
            $results = $tutorials;
            $tutorials = count($tutorials);
        } else {
            $query_builder = $this->tutorial->where('title', 'like', $raw);

            if (! is_null($author)) {
                $query_builder = $query_builder->where('author_id', (int) $author);
            }

            $tutorials = $query_builder->count();
        }

        if ($filter === 'podcast') {
            $podcasts = $this->podcast->where('title', 'like', $raw)->get();
            $results = $podcasts;
            $podcasts = count($podcasts);
        } else {
            $podcasts = $this->podcast->where('title', 'like', $raw)->count();
        }

        if ($filter === 'formation') {
            $formations = $this->curriculum->where('published', true)->where('title', 'like', $raw)->get();
            $results = $formations;
            $formations = count($formations);
        } else {
            $formations = $this->curriculum->where('title', 'like', $raw)->count();
        }

        if ($filter === 'question') {
            $questions = $this->question->where('title', 'like', $raw)->get();
            $results = $questions;
            $questions = count($questions);
        } else {
            $questions = $this->question->where('title', 'like', $raw)->count();
        }

        if (! isset($results)) {
            $results = [];
        }

        $author_active = $request->get('author');
        $technologie_active = $request->get('technologie');

        return view(
            'search.index',
            compact('results', 'query', 'filter', 'formations', 'podcasts', 'questions', 'tutorials', 'author_active')
        );
    }
}
