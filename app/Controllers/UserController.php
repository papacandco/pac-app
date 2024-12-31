<?php

namespace App\Controllers;

use App\Models\User;
use Dompdf\Dompdf;
use Bow\Http\Request;

class UserController extends Controller
{
    /**
     * Show user profile
     *
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        $user = $request->user();

        return view('user.setting', compact('user'));
    }

    /**
     * Show user Bookmark
     *
     * @param  string $type
     * @return mixed
     */
    public function showBookmark(Request $request)
    {
        /** @var User */
        $user = $request->user();
        $type = $request->get('type', 'tutorial');

        $bookmarks = match ($type) {
            'tutorial' => $user->tutorialBookmarks(),
            'curriculum' => $user->curriculumBookmarks(),
            'question' => $user->questionBookmarks(),
            'podcast' => $user->podcastBookmarks(),
            default => null,
        };

        if (is_null($bookmarks)) {
            return app_abort(404);
        }

        return view('user.bookmarks.' . $type, compact('user', 'bookmarks'));
    }

    /**
     * Show user Message
     *
     * @return mixed
     */
    public function showNotification(Request $request)
    {
        $user = $request->user();

        $notifications = $user->notifications ?? [];

        return view('user.notification', compact('user', 'notifications'));
    }

    /**
     * Show user transaction
     *
     * @return mixed
     */
    public function showTransaction(Request $request)
    {
        $user = $request->user();

        $transactions = $user->transactions()->where('status', 'success')->get();

        return view('user.transaction', compact('user', 'transactions'));
    }

    /**
     * Show user transaction invoice
     *
     * @return mixed
     */
    public function showTransactionInvoice(Request $request, string $transaction_id)
    {
        $user = $request->user();

        $transaction = $user->transactions()
            ->where('status', 'success')
            ->where('id', $transaction_id)
            ->first();

        $invoice_number = $user->transactions()
            ->where('created_at', '<', $transaction->created_at)
            ->count() + 1;

        $content = view('user.invoice', compact('user', 'transaction', 'invoice_number'))->render();

        $dompdf = new Dompdf();

        $dompdf->loadHtml($content);
        $dompdf->render();
        $dompdf->stream();
    }

    /**
     * Update user information
     *
     * @return mixed
     */
    public function updateInformation(Request $request)
    {
        $user = $request->user();

        $validation = $this->validation($request);

        if ($validation->fails()) {
            return redirect()
                ->back()
                ->withFlash('error', 'Impossible de mettre à jour vos information.');
        }

        $pseudo = $request->get('pseudo');

        if (User::where('pseudo', $pseudo)->where('id', '!=', $user->id)->exists()) {
            return redirect()
                ->back()
                ->withFlash('error', "Le pseudo $pseudo est déjà utilisé");
        }

        // Update user information
        $user->fill(
            $request->only(
                [
                'email', 'name', 'password', 'pseudo', 'sexe', 'country',
                ]
            )
        );

        $user->touch();

        return redirect()
            ->back()
            ->withFlash('success', 'Mise à jour effectiée !');
    }

    /**
     * Path user theme
     *
     * @return mixed
     */
    public function patchTheme(Request $request)
    {
        $user = $request->user();

        $user->theme = ! $user->theme;

        $user->touch();

        return response()->json(['status' => 'ok']);
    }

    /**
     * Update user avatar
     *
     * @param  array $additonnal_rules
     * @return mixed
     */
    public function validation(Request $request, $additonnal_rules = [])
    {
        if ($request->has('password')) {
            $additonnal_rules['password'] = [
                'required',
                'confirmed',
            ];
        }

        if ($request->has('pseudo')) {
            $additonnal_rules['pseudo'] = [
                'required',
                'min:5',
                'max:16',
            ];
        }

        $rules = [
            'email' => ['required', 'email'],
            'name' => ['required'],
            'sexe' => ['required', 'in:man,woman'],
        ];

        $rules = array_merge($rules, $additonnal_rules);

        return validator($request->all(), $rules);
    }

    /**
     * Delete the all notifications
     *
     * @return mixed
     */
    public function deleteNotifications(Request $request)
    {
        $user = $request->user();

        $user->notifications()->delete();

        return redirect()
            ->back()
            ->withFlash('success', 'Toutes les notifications ont été supprimé !');
    }

    /**
     * Delete the all notifications
     *
     * @return mixed
     */
    public function readNotifications(Request $request)
    {
        $user = $request->user();

        $user->unreadNotifications()->each(fn ($notification) => $notification->markAsRead());

        return redirect()
            ->back()
            ->withFlash('success', 'Tout les notifications ont été marqué comme lu !');
    }
}
