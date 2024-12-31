<?php

namespace App\Controllers\Tutorial;

use App\Controllers\Controller;
use App\Models\User;
use App\Services\TutorialService;
use Bow\Http\Request;

class TutorialController extends Controller
{
    /**
     * TutorialController constructor.
     *
     * @return void
     */
    public function __construct(
        private TutorialService $service
    ) {
    }

    /**
     * Show tutorial list
     *
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        $technologie = $request->get('technologie');
        $author = $request->get('author');
        $url = $request->url();

        $tutorials = $this->service->getTutorialPagination(
            $technologie,
            $url,
            $author
        );

        $author_active = $request->get('author');

        return view('tutorial.index', compact('tutorials', 'author_active'));
    }

    /**
     * Show single tutorial
     *
     * @return mixed
     */
    public function showTutorial(Request $request, string $slug, int $tutorial_id)
    {
        $data = $this->service->getSingleTutorial($slug, $tutorial_id);

        if (! is_array($data)) {
            return $data;
        }

        return view('tutorial.reader', $data);
    }

    /**
     * Confirm the tutorial has marque
     *
     * @param  int $curriculum_id
     * @return mixed
     */
    public function confirmProgrestion(Request $request, int $tutorial_id)
    {
        $tutorial = $this->service->find($tutorial_id);

        if (is_null($tutorial)) {
            return redirect()
                ->back()
                ->withFlash('danger', 'Désolé une erreur est survenu !');
        }

        /** @var User*/
        $user = $request->user();

        // Create the new progrestion or get progrestion
        $progrestion = $tutorial->progrestion($user);

        $progrestion->ended_at = now();
        $progrestion->ended = true;
        $progrestion->timespent = strtotime($progrestion->ended_at) - strtotime($progrestion->started_at);
        $progrestion->touch();

        return redirect()->back()->withFlash('success', 'Marqué comme terminé !');
    }

    /**
     * Update tutorial timespent
     *
     * @return mixed
     */
    public function updateTimespentProgrestion(Request $request, int $tutorial_id)
    {
        $tutorial = $this->service->find($tutorial_id);

        if (is_null($tutorial)) {
            return response()->json(
                [
                'success' => false,
                'message' => 'Désolé une erreur est survenu !',
                ]
            );
        }

        /** @var User */
        $user = $request->user();

        // Create the new progrestion
        $progrestion = $tutorial->progrestion($user);

        $progrestion->timespent = time() - strtotime($progrestion->started_at);
        $progrestion->touch();

        return response()->json(['success' => true]);
    }
}
