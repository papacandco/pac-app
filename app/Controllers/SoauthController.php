<?php

namespace App\Controllers;

use App\Models\User;
use Bow\Http\Request;
use Bow\Soauth\Soauth;
use Bow\Database\Barry\Model;
use App\Controllers\Controller;

class SoauthController extends Controller
{
    /**
     * The available providers
     *
     * @var array
     */
    public const PROVIDERS = ['github'];

    /**
     * SocialiteController controller
     *
     * @return mixed
     */
    public function __construct(
        private User $user
    ) {
    }

    /**
     * Show the application's login form.
     *
     * @return
     */
    public function showLoginForm(Request $request)
    {
        if ($request->has('redirect')) {
            $request->session()->put('redirect', $request->get('redirect'));
        }

        return view('auth.login');
    }

    /**
     * Build auth process in the specifique provider
     *
     * @param  string $provider
     * @return mixed
     */
    public function provider($provider)
    {
        if (! in_array($provider, static::PROVIDERS)) {
            return app_abort(404);
        }

        return Soauth::redirect($provider);
    }

    /**
     * Process the redirection
     *
     * @param  string $provider
     * @return mixed
     */
    public function process(Request $request, $provider)
    {
        if (! in_array($provider, static::PROVIDERS)) {
            return app_abort(404);
        }

        try {
            // Get user information from provider api
            $user = Soauth::resource($provider);
        } catch (\Exception $exception) {
            return redirect()
                ->route('login')
                ->withFlash('social_error', $provider);
        }

        $email = $user->getEmail();

        if (is_null($email)) {
            $email = sprintf('%s_stub_email@papac.dev', $user->getId());
        }

        $pseudo = $provider . '_' . $user->getNickname();

        // Find the user by email
        $registed_user = $this->user->where('email', $email)->first();

        // Create the new user account if he not exists
        if (is_null($registed_user)) {
            $registed_user = $this->create([
                'avatar' => $user->getAttribute('avatar_url'),
                'pseudo' => $pseudo,
                'name' => $user->getName(),
                'email' => $email,
                'email_verified_at' => app_now(),
                'provider_id' => $user->getId(),
                'provider_type' => $provider,
                'logged_at' => app_now(),
            ]);

            // Send the welcome email
            $registed_user->sendWelcomeNotification();
        }

        // Log user
        auth()->login($registed_user);

        // Create the flash information
        $message = sprintf(__('auth.welcome'), $registed_user->name);

        // Build the redirection route
        if ($request->session()->has('redirect')) {
            $route = $request->session()->get('redirect');
        } else {
            $route = route('user.bookmark');
        }

        return redirect()
            ->to($route)
            ->withFlash('success', $message);
    }

    /**
     * The cancel authentorisation
     *
     * @param  string $provider
     * @return mixed
     */
    public function cancel(Request $request, $provider)
    {
        return view('errors.oauth', compact('provider'));
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @return Model
     */
    protected function create(array $data): Model
    {
        $data = array_merge($data, ['password' => null, 'logged_at' => now(),]);

        return $this->user->create($data);
    }

    /**
     * The user has logged out of the application.
     *
     * @return mixed
     */
    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()
            ->flash('success', __('auth.logout-message'));

        return redirect(route('login'));
    }
}
