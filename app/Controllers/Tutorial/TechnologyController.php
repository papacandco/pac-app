<?php

namespace App\Controllers\Tutorial;

use App\Controllers\Controller;
use App\Models\Technology;
use Bow\Http\Request;

class TechnologyController extends Controller
{
    /**
     * TechnologyController constructor
     */
    public function __construct(
        private Technology $technologie
    ) {
    }

    /**
     * Show technologie tutorials
     *
     * @param  string $technologie_slug
     * @return mixed
     */
    public function __invoke(Request $request, $technologie_slug)
    {
        $technologie = $this->technologie
            ->where('parent_id', 0)
            ->where('slug', $technologie_slug)->first();

        if (!$technologie) {
            return app_abort(404);
        }

        $author_active = $request->get('author');

        $technologie->tutorials()->where('published', true);

        if (! is_null($author_active)) {
            $technologie->tutorials()->where('author_id', $author_active);
        }

        return view('technologie.index', compact('technologie', 'author_active'));
    }
}
