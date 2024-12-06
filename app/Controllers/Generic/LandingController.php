<?php

namespace App\Controllers\Generic;

use App\Controllers\Controller;
use App\Models\Annonce;
use App\Models\Challenge;
use App\Models\Configuration;
use App\Models\Curriculum;
use App\Models\Technologie;
use App\Models\Tutorial;
use Bow\Http\Request;
use Illuminate\Support\Str;

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
        private Technologie $technologie
    ) {}

    /**
     * Show landing page
     *
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        $tutorials = $this->tutorial->latestPublication(4);
        $configuration = $this->configuration->first();

        if (is_null($configuration)) {
            return abort(503);
        }

        // Get annonce information
        $annonce = $this->annonce->online()
            ->whereIn('type', [Annonce::ANNONCE_NEW, Annonce::ANNONCE_JOB])
            ->first();

        $secure_prefix = Str::random(8);

        return view('vendor.landing', compact(
            'tutorials',
            'configuration',
            'annonce',
            'secure_prefix'
        ));
    }
}
