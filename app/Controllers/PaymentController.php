<?php

namespace App\Controllers;

use App\Models\User;
use Bow\Support\Log;
use Bow\Http\Request;
use Ramsey\Uuid\Uuid;
use App\Models\Country;
use App\Models\Product;
use App\Models\Tutorial;
use App\Models\Curriculum;
use App\Models\Transaction;
use Bow\Validation\Validate;
use Bow\Validation\Validator;
use App\Services\CinetpayService;
use App\Events\PaymentSuccessfulEvent;
use App\Messages\DonationFailedMessage;
use App\Messages\DonationSuccessMessage;
use App\Messages\SubscriptionFailedMessage;
use App\Messages\SubscriptionSuccessMessage;
use App\Messages\ElementPaymentFailedMessage;
use App\Messages\ElementPaymentSuccessMessage;

class PaymentController extends Controller
{
    /**
     * The merchant reference
     *
     * @var string
     */
    public const REFERENCE = 'Papac & Co';

    /**
     * The failed flag
     *
     * @var string
     */
    public const FAILED = 'failed';

    /**
     * The success flag
     *
     * @var string
     */
    public const SUCCESS = 'success';

    /**
     * DonationController constructor
     *
     * @return mixed
     */
    public function __construct(
        private Product $product,
        private Tutorial $tutorial,
        private Curriculum $curriculum,
        private Transaction $transaction,
        private CinetpayService $cinetpayService
    ) {
    }

    /**
     * Show donate form
     *
     * @return mixed
     */
    public function showDonate()
    {
        return view('payment.donation.donate');
    }

    /**
     * Show the payment form
     *
     * @return mixed
     */
    public function showPayment(
        Request $request,
        string $type,
        string $slug,
        string $id
    ) {
        $user = $request->user();

        $element = match ($type) {
            'tutorials' => $this->tutorial->findOrFail($id),
            'curriculums' => $this->curriculum->findOrFail($id),
            default => null,
        };

        if (is_null($element)) {
            return app_abort(404);
        }

        if (! $user->hasPurchased($element)) {
            return view('payment.element.payment', compact('element'));
        }

        if ($element instanceof Tutorial) {
            return redirect()
                ->route('tutorial.reader', ['id' => $element->id, 'slug' => $element->slug])
                ->withFlash('error', 'Vous avez déjà acheté ce contenu');
        }

        return redirect()
            ->route('curriculum.single', ['id' => $element->id, 'slug' => $element->slug])
            ->withFlash('error', 'Vous avez déjà acheté ce contenu');
    }

    /**
     * Show the payment form
     *
     * @return mixed
     */
    public function showProduct(
        Request $request,
        string $product_id,
    ) {
        $user = $request->user();

        $product = $this->product->whereProductId($product_id)->first();

        if ($user->hasSubscribe($product)) {
            return redirect()
                ->route('user.bookmark')
                ->withFlash('error', 'Vous avez déjà acheté ce contenu');
        }

        return view('payment.subscription.payment', compact('product'));
    }

    /**
     * Make donation
     *
     * @return mixed
     */
    public function donate(Request $request)
    {
        $validation = $this->validation($request);

        if ($validation->fails()) {
            return redirect()
                ->back()
                ->withFlash(
                    'error',
                    "Nous n'avons pas pu valider votre demande."
                    . '<br />Merci de reéssayer.'
                );
        }

        $amount = (float) $request->get('amount');
        $currency = $request->get('currency');
        $transaction = Uuid::uuid4();

        /** @var User */
        $user = $this->getUser($request);

        $payment = $this->cinetpayService->generatePaymentUrl(
            $user,
            $transaction,
            $amount,
            $currency
        );

        if ($payment === false) {
            return redirect()
                ->back()
                ->withFlash(
                    'error',
                    "Nous n'avons pas pu valider votre demande."
                    . '<br />Merci de reéssayer.'
                );
        }

        // Create associate transaction
        $this->transaction->create(
            [
            'id' => $transaction,
            'amount' => $amount,
            'provider' => 'cinetpay',
            'type' => 'donation',
            'target_id' => $user->getKey(),
            'target_type' => get_class($user),
            'user_id' => $user->getKey(),
            'user_type' => get_class($user),
            'extras' => json_encode(
                [
                'provider_data' => $payment,
                'currency' => $currency,
                'reference' => static::REFERENCE,
                'ip' => $request->ip(),
                'user_agent' => $request->getHeader('x-user-agent'),
                ]
            ),
            ]
        );

        return redirect($payment->payment_url);
    }

    /**
     * Create a new user subscription
     *
     * @return mixed
     */
    public function subscribe(
        Request $request,
        string $product_id
    ) {
        $product = $this->product->whereProductId($product_id)->first();
        $transaction = Uuid::uuid4();
        /** @var User */
        $user = $request->user();
        $currency = $request->get('currency');

        if (is_null($currency) || ! in_array($currency, ['XOF'])) {
            return redirect()
                ->back()
                ->withFlash(
                    'error',
                    "Nous n'avons pas pu valider votre demande."
                    . '<br />Merci de reéssayer.'
                );
        }

        $payment = $this->cinetpayService->generatePaymentUrl(
            $user,
            $transaction,
            $product->price,
            $currency,
            sprintf('subscription to product %s', $product->id)
        );

        // Create associate transaction
        $this->transaction->create([
            'id' => $transaction,
            'amount' => $product->price,
            'status' => 'pending',
            'provider' => 'cinetpay',
            'type' => 'subscription',
            'target_id' => $product->getKey(),
            'target_type' => get_class($product),
            'user_id' => $user->getKey(),
            'user_type' => get_class($user),
            'extras' => json_encode([
                'provider_data' => $payment,
                'currency' => $currency,
                'reference' => sprintf('subscription to product %s', $product->id),
                'ip' => $request->ip(),
                'user_agent' => $request->getHeader('user-agent'),
            ]),
        ]);

        return redirect()->to($payment->payment_url);
    }

    /**
     * Initialize payment
     *
     * @return mixed
     */
    public function payment(Request $request)
    {
        $element_type = $request->get('element_type');
        $element_id = $request->get('element_id');
        $currency = $request->get('currency');

        if (! class_exists($element_type, true)) {
            return app_abort(404);
        }

        if (is_null($currency) || ! in_array($currency, ['XOF'])) {
            return redirect()
                ->back()
                ->withFlash(
                    'error',
                    "Nous n'avons pas pu valider votre demande."
                    . '<br />Merci de reéssayer.'
                );
        }

        $element = (new $element_type())->findOrFail($element_id);
        $transaction = Uuid::uuid4();
        /** @var User */
        $user = $request->user();
        $type = $element instanceof Tutorial ? 'tutorial' : 'curriculum';
        $message = sprintf('payment of %s %s by %s', $element->id, $type, $user->id);

        $payment = $this->cinetpayService->generatePaymentUrl(
            $user,
            $transaction,
            $element->price,
            $currency,
            $message
        );

        // Create associate transaction
        $this->transaction->create(
            [
            'id' => $transaction,
            'amount' => $element->price,
            'status' => 'pending',
            'provider' => 'cinetpay',
            'type' => 'element',
            'target_id' => $element->getKey(),
            'target_type' => get_class($element),
            'user_id' => $user->getKey(),
            'user_type' => get_class($user),
            'extras' => json_encode(
                [
                'provider_data' => $payment,
                'currency' => $currency ?? 'XOF',
                'reference' => $message,
                'ip' => $request->ip(),
                'user_agent' => $request->getHeader('user-agent'),
                ]
            ),
            ]
        );

        return redirect()->to($payment->payment_url);
    }

    /**
     * Payment confirmation
     *
     * @return mixed
     */
    public function paymentConfirmation(
        Request $request,
        string $transaction_id
    ) {
        $attributes = $request->all();

        // Check the hmac token
        $this->cinetpayService->checkHmacToken(
            (string) $request->getHeader('X-Token'),
            $attributes
        );

        $transaction = $this->transaction->whereId($transaction_id)->first();

        // Find the donation information
        if (is_null($transaction)) {
            Log::stack(['payment', 'slack'])
                ->warning('payment with [' . $transaction_id . '] do not exists in database');

            return response()->send('payment failed');
        }

        // Get the request information
        $provider_transaction = $this->cinetpayService->getPaymentStatus($transaction_id);

        // Update donation data
        $transaction->status = strtolower($provider_transaction->status);
        $transaction->touch();

        if ($transaction->isSuccess()) {
            match ($transaction->type) {
                'element' => $transaction->user->purchase($transaction->target),
                'subscription' => $transaction->user->subscribe($transaction->target),
                default => null,
            };

            event(new PaymentSuccessfulEvent($transaction));
        }

        match ($transaction->type) {
            'donation' => $this->sendDonationMessage($transaction),
            'subscription' => $this->sendSubscriptionMessage($transaction),
            'element' => $this->sendElementMessage($transaction),
            default => null,
        };

        return response()->send($provider_transaction->status);
    }

    /**
     * Check payment status
     *
     * @return mixed
     */
    public function paymentStatus(Request $request, string $transaction_id)
    {
        $transaction = $this->transaction->whereId($transaction_id)->first();

        if ($transaction->isSuccess()) {
            return view('payment.' . $transaction->type . '.success', compact('transaction'));
        }

        // Get the transaction status
        $provider_transaction = $this->cinetpayService->getPaymentStatus($transaction_id);

        if ($provider_transaction == false || $provider_transaction->status !== 'success') {
            if ($transaction->isPending()) {
                $transaction->status = 'failed';
                $transaction->extras->provider_data = json_encode($provider_transaction);
                $transaction->touch();
            }

            return view('payment.' . $transaction->type . '.failed', compact('transaction'));
        }

        if ($transaction->isPending()) {
            $transaction->status = $provider_transaction->status;
            $transaction->extras->provider_data = json_encode($provider_transaction);
            $transaction->touch();

            match ($transaction->type) {
                'donation' => $this->sendDonationMessage($transaction),
                'subscription' => $this->sendSubscriptionMessage($transaction),
                'element' => $this->sendElementMessage($transaction),
                default => null,
            };

            if ($transaction->isSuccess()) {
                match ($transaction->type) {
                    'element' => $transaction->user->purchase($transaction->target),
                    'subscription' => $transaction->user->subscribe($transaction->target),
                    default => null,
                };

                event(new PaymentSuccessfulEvent($transaction));
            }
        }

        return view('payment.' . $transaction->type . '.success', compact('transaction'));
    }

    /**
     * Cancel payment
     *
     * @param Request $request
     * @return mixed
     */
    public function canelPayment(Request $request, string $transaction_id): mixed
    {
        $transaction = $this->transaction->whereId($transaction_id)->first();

        if ($transaction->status === 'pending') {
            $transaction->status = 'canceled';
            $transaction->touch();
        }

        return view('payment.' . $transaction->type . '.cancel', compact('transaction'));
    }

    /**
     * Send message
     *
     * @param  Transaction $transaction
     * @return void
     */
    private function sendDonationMessage(Transaction $transaction)
    {
        // Log payment information
        if ($transaction->status != static::SUCCESS) {
            Log::stack(['payment', 'slack'])
                ->error('payment [' . $transaction->status . '] with [' . $transaction->id . ']');

            $message = new DonationFailedMessage($transaction);
        } else {
            Log::stack(['payment', 'slack'])
                ->info('payment [' . $transaction->status . '] amount: [' . $transaction->amount . ' XOF] - ' . $transaction->id);

            $message = new DonationSuccessMessage($transaction);
        }

        $transaction->user->sendMessage($message);
    }

    /**
     * Send message
     *
     * @param  Transaction $transaction
     * @return void
     */
    private function sendSubscriptionMessage(Transaction $transaction)
    {
        // Log payment information
        if ($transaction->status != static::SUCCESS) {
            Log::stack(['payment', 'slack'])
                ->error('payment [' . $transaction->status . '] with [' . $transaction->id . ']');

            $message = new SubscriptionFailedMessage($transaction);
        } else {
            Log::stack(['payment', 'slack'])
                ->info('payment [' . $transaction->status . '] amount: [' . $transaction->amount . ' XOF] - ' . $transaction->id);

            $message = new SubscriptionSuccessMessage($transaction);
        }

        $transaction->user->sendMessage($message);
    }

    /**
     * Send message
     *
     * @param  Transaction $transaction
     * @return void
     */
    private function sendElementMessage(Transaction $transaction)
    {
        // Log payment information
        if ($transaction->status != static::SUCCESS) {
            Log::stack(['payment', 'slack'])
                ->error('payment [' . $transaction->status . '] with [' . $transaction->id . ']');

            $message = new ElementPaymentFailedMessage($transaction);
        } else {
            Log::stack(['payment', 'slack'])
                ->info('payment [' . $transaction->status . '] amount: [' . $transaction->amount . ' XOF] - ' . $transaction->id);

            $message = new ElementPaymentSuccessMessage($transaction);
        }

        $transaction->user->sendMessage($message);
    }

    /**
     * Get user info
     *
     * @param Request $request
     */
    protected function getUser(Request $request)
    {
        $user = $request->user();

        if (is_null($user->country)) {
            $country = Country::whereCode($request->get('country'))->first();
        } else {
            $country = Country::whereCode($user->country)->orWhere('name', $user->country)->first();
        }

        $user->country = $country->name;
        $user->touch();

        return $user;
    }

    /**
     * Make data validation
     *
     * @param Request $request
     * @return Validate
     */
    protected function validation(Request $request): Validate
    {
        $rules = [
            'amount' => 'required|numeric',
            'currency' => 'required|in:XOF,USD,XAF,CDF,GNF',
        ];

        if (! $request->user()) {
            $rules['name'] = 'required';
            $rules['email'] = 'required|email';
        }

        return Validator::make($request->all(), $rules);
    }
}
