<?php

namespace App\Controllers\Tutorial;

use App\Controllers\Controller;
use App\Models\Challenge;
use Bow\Http\Request;

class ChallengeController extends Controller
{
    /**
     * ChallengeController constructor.
     */
    public function __construct(
        private Challenge $challenge
    ) {}

    /**
     * Show challenge listing
     *
     * @return mixed
     */
    public function __invoke()
    {
        $challenges = $this->challenge
            ->orderBy('diffused_at', 'asc')
            ->orderBy('diffused', 'desc')
            ->get();

        $current_challenge = $challenges->get(0);

        if (! is_null($current_challenge)) {
            $challenges = $challenges->filter(
                fn ($challenge) => $challenge->id != $current_challenge->id
            );
        }

        return view('challenge.index', compact('challenges', 'current_challenge'));
    }

    /**
     * Show the challenge
     *
     * @param  int  $challenge_id
     * @return mixed
     */
    public function show(Request $request, $slug, $challenge_id)
    {
        $challenge = $this->challenge->findOrFail($challenge_id);

        if ($challenge->slug != $slug) {
            return abort(404);
        }

        return view('challenge.single', compact('challenge'));
    }

    /**
     * Show challenge direct
     *
     * @param  string  $slug
     * @param  int  $challenge_id
     * @return mixed
     */
    public function showDirect(Request $requst, $slug, $challenge_id)
    {
        $challenge = $this->challenge->findOrFail($challenge_id);

        if ($challenge->isDiffused()) {
            return view('challenge.error.already-diffused', ['challenge' => $challenge]);
        }

        if (! $challenge->inProgress()) {
            return view('challenge.error.diffusion-error', ['challenge' => $challenge]);
        }

        $access = $challenge->isPrivate() ? $requst->session()->has('access_challenge_'.$challenge->id) : true;

        return view('challenge.direct', compact('challenge', 'access'));
    }

    /**
     * Check the token
     *
     * @param  int  $challenge_id
     * @return mixed
     */
    public function checkToken(Request $request, $challenge_id)
    {
        $challenge = $this->challenge->findOrFail($challenge_id);

        $invitation = $challenge->invitation($request->user()->id);

        if (is_null($invitation)) {
            return redirect()
                ->back()
                ->withFlash('error', 'Vous n\'avez pas d\'invation.');
        }

        if ($invitation->access_token != $request->get('token')) {
            return redirect()
                ->back()
                ->withFlash('error', 'Token est invalide.');
        }

        if ($invitation->isAlreadyUsed()) {
            return redirect()
                ->back()
                ->withFlash('error', 'Token est déjà utilisé.');
        }

        $request->session()->put([
            'access_challenge_'.$challenge->id => true,
        ]);

        // Delete the invitation
        $invitation->status = 1;
        $invitation->touch();

        return redirect()
            ->back()
            ->withFlash('success', sprintf('Bienvenue au challenge <b>%s</b>.', $request->user()->name));
    }
}
