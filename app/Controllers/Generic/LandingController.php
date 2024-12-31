<?php

namespace App\Controllers\Generic;

use Bow\Http\Request;
use App\Models\Annonce;
use App\Models\Tutorial;
use App\Models\Challenge;
use App\Models\Curriculum;
use App\Models\Technology;
use App\Models\Configuration;
use App\Controllers\Controller;

class LandingController extends Controller
{
    /**
     * LandingController constructor.
     */
    public function __construct(
        private Tutorial $tutorial,
        private Challenge $challenge,
        private Configuration $configuration,
        private Annonce $annonce,
        private Curriculum $curriculum,
        private Technology $technologie
    ) {
    }

    /**
     * Show landing page
     *
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        $tutorials = $this->tutorial->latestPublication(6);
        $configuration = $this->configuration->first();

        if (is_null($configuration)) {
            return app_abort(503);
        }

        // Get annonce information
        $annonce = $this->annonce->online()
            ->whereIn('type', [Annonce::ANNONCE_NEW, Annonce::ANNONCE_JOB])
            ->first();

        return view('vendor.landing', compact('tutorials', 'configuration', 'annonce'));
    }
}
