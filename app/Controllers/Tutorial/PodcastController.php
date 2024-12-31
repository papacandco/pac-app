<?php

namespace App\Controllers\Tutorial;

use App\Controllers\Controller;
use App\Models\Podcast;
use Bow\Http\Request;

class PodcastController extends Controller
{
    /**
     * PodcastController constructor
     *
     * @return mixed
     */
    public function __construct(
        private Podcast $podcast
    ) {
    }

    /**
     * Show the list of podcast
     *
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        $podcast = $this->podcast->orderBy('created_at', 'desc')
            ->where('published', true)
            ->whereNotNull('published_at')
            ->first();

        if (is_null($podcast)) {
            return view('podcast.blank');
        }

        $podcasts = $this->podcast->where('id', '!=', $podcast->id)
            ->where('published', true)
            ->whereNotNull('published_at')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('podcast.single', compact('podcast', 'podcasts'));
    }

    /**
     * Show single podcast
     *
     * @return mixed
     */
    public function showPodcast(Request $request, string $slug, int $podcast_id)
    {
        $podcast = $this->podcast->where('id', $podcast_id)
            ->where('published', true)
            ->whereNotNull('published_at')
            ->first();

        $podcasts = $this->podcast->where('id', '!=', $podcast->id)->orderBy('created_at', 'desc')->paginate(5);

        return view('podcast.single', compact('podcast', 'podcasts'));
    }
}
