<?php

namespace App\Controllers\Api;

use Bow\Http\Request;
use Bow\Database\Collection;
use App\Controllers\Controller;
use App\Services\TutorialService;

class TutorialController extends Controller
{
    /**
     * Instance of TutorialService
     *
     * @var TutorialService
     */
    private $service;

    /**
     * TutorialController controller
     *
     * @return array
     */
    public function __construct(TutorialService $service)
    {
        $this->service = $service;
    }

    /**
     * Show the tutorial pagination
     *
     * @return array
     */
    public function __invoke(Request $request): Collection
    {
        $paginations = $this->service->getTutorialPagination($request->get('technologie'), $request->url());

        foreach ($paginations->values() as $tutorial) {
            $tutorial->route = route('tutorial.reader', ['slug' => $tutorial->slug, 'id' => $tutorial->id]);
            $tutorial->technologie_route = route('technologie.index', ['technologie' => $tutorial->technologie->slug]);
            $tutorial->description_truncated = str_words($tutorial->description, 14);
            $tutorial->title_truncated = $tutorial->title;
        }

        return $paginations;
    }
}
