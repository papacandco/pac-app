<?php

namespace App\Controllers\Generic;

use App\Controllers\Controller;
use App\Models\Challenge;
use App\Models\Curriculum;
use App\Models\Question;
use App\Models\Tutorial;
use Bow\Http\Request;

class BookmarkController extends Controller
{
    /**
     * The bookmarkabe list
     *
     * @var array
     */
    private $bookmarkables = [
        'tutorial' => Tutorial::class,
        'challenge' => Challenge::class,
        'question' => Question::class,
        'curriculum' => Curriculum::class,
        'podcast' => \App\Models\Podcast::class,
    ];

    /**
     * Mark tutorial
     *
     * @param  int  $bookmarkable_id
     * @return mixed
     */
    public function bookmark(Request $request, $bookmarkable_id)
    {
        // Get the bookmarkable type.
        $type = $request->get('type');

        if (! array_key_exists($type, $this->bookmarkables)) {
            return redirect()
                ->back()
                ->withFlash('error', __('controller.bookmark.error'));
        }

        // Find bookmarkable instance
        $bookmarkable = (new $this->bookmarkables[$type])
            ->findOrFail($bookmarkable_id);

        // Get user information
        $user = $request->user();

        if ($user->hasBookmarked($bookmarkable)) {
            return redirect()
                ->back()
                ->withFlash('warning', __('controller.bookmark.'.$type.'.warning'));
        }

        // Mark to bookmarking
        $user->mark($bookmarkable);

        return redirect()
            ->back()
            ->withFlash('success', __('controller.bookmark.'.$type.'.success'));
    }

    /**
     * Remove bookmarkable
     *
     * @param  int  $bookmarkable_id
     * @return mixed
     */
    public function remove(Request $request)
    {
        $type = $request->get('type');

        if (! array_key_exists($type, $this->bookmarkables)) {
            return redirect()
                ->back()
                ->withFlash('error', __('controller.bookmark.error'));
        }

        // Get user information
        $user = $request->user();

        $bookmarkable = $user->bookmarks()
            ->whereId((int) $request->get('id'))
            ->wherePurchased(false)
            ->firstOrFail();

        if (! $bookmarkable) {
            return redirect()
                ->back()
                ->withFlash('error', __('controller.bookmark.error'));
        }

        $bookmarkable->delete();

        if ($type == 'tutorial') {
            $message = 'Tutoriel supprimé de votre liste de favoris!';
        } elseif ($type == 'curriculum') {
            $message = 'Formation supprimé de votre liste de favoris!';
        } else {
            $message = 'Bookmark supprimé.';
        }

        return redirect()->back()->withFlash('success', $message);
    }
}
