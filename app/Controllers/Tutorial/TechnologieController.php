<?php

namespace App\Controllers\Tutorial;

use App\Controllers\Controller;
use App\Models\Technologie;
use Bow\Http\Request;

class TechnologieController extends Controller
{
    /**
     * TechnologieController constructor
     */
    public function __construct(
        private Technologie $technologie
    ) {}

    /**
     * Show technologie tutorials
     *
     * @param  string  $technologie_slug
     * @return mixed
     */
    public function __invoke(Request $request, $technologie_slug)
    {
        $technologie = $this->technologie
            ->where('parent_id', 0)
            ->whereSlug($technologie_slug)->firstOrFail();

        $author_active = $request->get('author');

        $technologie->load(['tutorials' => function ($query) use ($author_active) {
            $query = $query->wherePublished(true);

            if (! is_null($author_active)) {
                $query->whereAuthorId($author_active);
            }

            return $query;
        }]);

        return view('technologie.index', compact('technologie', 'author_active'));
    }
}
