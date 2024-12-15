<?php

namespace App\Controllers\Generic;

use App\Controllers\Controller;
use App\Models\Curriculum;
use App\Models\Podcast;
use App\Models\Question;
use App\Models\Technologie;
use App\Models\Tutorial;
use Bow\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    /**
     * SearchController constructor
     */
    public function __construct(
        private Tutorial $tutorial,
        private Podcast $podcast,
        private Technologie $technologie,
        private Question $question,
        private Curriculum $curriculum
    ) {}

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

        if (! in_array($filter, ['formation', 'podcast', 'tutorial', 'question'])) {
            return app_abort(404);
        }

        Log::info('information recherchez: '.$query);

        $raw = DB::raw("'%$query%'");

        if ($filter === 'tutorial') {
            $tutorials = $this->tutorial
                ->wherePublished(true)
                ->where('title', 'like', $raw);
            if (! is_null($author)) {
                $tutorials = $tutorials->whereAuthorId((int) $author);
            }
            $tutorials = $tutorials->get();
            $results = $tutorials;
            $tutorials = count($tutorials);
        } else {
            $tutorials = $this->tutorial
                ->where('title', 'like', $raw);

            if (! is_null($author)) {
                $tutorials = $tutorials->whereAuthorId((int) $author);
            }

            $tutorials = $tutorials->count();
        }

        if ($filter === 'podcast') {
            $podcasts = $this->podcast
                ->where('title', 'like', $raw)
                ->get();
            $results = $podcasts;
            $podcasts = count($podcasts);
        } else {
            $podcasts = $this->podcast
                ->where('title', 'like', $raw)
                ->count();
        }

        if ($filter === 'formation') {
            $formations = $this->curriculum
                ->wherePublished(true)
                ->where('title', 'like', $raw)
                ->get();
            $results = $formations;
            $formations = count($formations);
        } else {
            $formations = $this->curriculum
                ->where('title', 'like', $raw)
                ->count();
        }

        if ($filter === 'question') {
            $questions = $this->question
                ->where('title', 'like', $raw)
                ->get();
            $results = $questions;
            $questions = count($questions);
        } else {
            $questions = $this->question
                ->where('title', 'like', $raw)
                ->count();
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
