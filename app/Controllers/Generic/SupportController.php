<?php

namespace App\Controllers\Generic;

use App\Controllers\Controller;
use App\Controllers\Traits\UploadedFileTrait;
use App\Models\Newsletter;
use Bow\Http\Request;
use Bow\Http\UploadedFile;

class SupportController extends Controller
{
    use UploadedFileTrait;

    /**
     * The cookie life
     *
     * @var int
     */
    public const COOKE_LIFE = 8640000;

    /**
     * Add the new email in the new letter
     *
     * @return mixed
     */
    public function addNewsletter(Request $request)
    {
        $field_name = $request->get('field_name', 'newsletter_email_field');
        $email_field = $request->session()->get($field_name);

        $validation = validator(
            $request->all(),
            [
                $email_field => 'required|email',
            ]
        );

        // Check the validation
        if ($validation->fails()) {
            return redirect()
                ->back()
                ->withFlash('error', __('vendor.data-validation-error'));
        }

        // Check if email already exists
        if (Newsletter::hasEmail($request->get($email_field))) {
            return redirect()
                ->back()
                ->withFlash('warning', __('vendor.email-already-exists'));
        }

        // Create the new email
        Newsletter::create(['email' => $request->get($email_field)]);

        return redirect()
            ->back()
            ->withFlash('success', __('vendor.email-have-been-save'));
    }

    /**
     * Show the application terms and policy
     *
     * @return mixed
     */
    public function showTerms()
    {
        return view('vendor.terms');
    }

    /**
     * Show about
     *
     * @return mixed
     */
    public function showAbout()
    {
        return view('vendor.about');
    }

    /**
     * Show pricing
     *
     * @return mixed
     */
    public function showPricing()
    {
        return view('vendor.pricing');
    }

    /**
     * Upload file from editormd editor
     *
     * @return mixed
     */
    public function uploadStaticFile(Request $request)
    {
        /** @var UploadedFile */
        $uploaded_file = $request->file('file');

        $cover = $this->uploadMaterial($uploaded_file, 'shared', time(), time());

        return response()->json(['url' => $cover, 'message' => 'Envoyé avec succès', 'success' => 1]);
    }

    /**
     * Accept cookie contracts
     *
     * @return mixed
     */
    public function acceptCookieContracts()
    {
        cookie('cookie-contract', true, static::COOKE_LIFE);

        return response()
            ->json(['ok' => true, 'message' => 'Nous vous souhaitons une très belle expérience 😊']);
    }
}
