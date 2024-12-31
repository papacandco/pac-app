<?php

namespace App\Controllers\Tutorial;

use App\Controllers\Controller;
use App\Services\CurriculumService;
use Bow\Http\Request;

class CurriculumController extends Controller
{
    /**
     * CurriculumController constructor
     */
    public function __construct(
        private CurriculumService $service
    ) {
    }

    /**
     * Show the list of formation
     *
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        $curriculums = $this->service->getCurriculumPagination();

        return view('curriculum.index', compact('curriculums'));
    }

    /**
     * Show the list of formation
     *
     * @param  string $slug
     * @return mixed
     */
    public function show(Request $request, $slug)
    {
        $user = $request->user();
        $data = $this->service->getCurriculum($slug);

        $followed = false;
        $tutorial = false;

        // Check if user follow the curriculum
        if ($user) {
            $followed = $user->hasBookmark($data['curriculum']);
        }

        if ($followed) {
            $progrestion = $data['curriculum']
                ->progrestions()
                ->where('user_id', $user->id)
                ->orderBy('started_at', 'desc')
                ->first();

            if ($progrestion) {
                $tutorial = $progrestion->tutorial;
            } else {
                $section = $data['curriculum']->sections()->first();
                if ($section) {
                    $graph = $section->graphs()->first();
                    if ($graph) {
                        $tutorial = $graph->element;
                    }
                }
            }
        }

        $data['followed'] = $followed;
        $data['tutorial'] = $tutorial;

        return view('curriculum.single', $data);
    }
}
