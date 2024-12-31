<?php

namespace App\Services;

use App\Models\User;
use Bow\Http\Client\HttpClient;
use Bow\Http\Exception\BadRequestException;

class CinetpayService
{
    /**
     * Generate the cinetpay
     *
     * @return mixed
     */
    public function generatePaymentUrl(
        User $user,
        string $transaction,
        float $amount,
        string $currency = 'XOF',
        string $message = 'Code Learning Donation'
    ) {
        $credentials = [
            'apikey' => app_env('CINETPAY_KEY'),
            'site_id' => app_env('CINETPAY_SITE_ID'),
        ];

        $payload = [
            'transaction_id' => $transaction,
            'amount' => $amount,
            'currency' => $currency,
            'description' => $message,
            'notify_url' => route('payment.confirmation', compact('transaction')),
            'return_url' => route('payment.congratulation', compact('transaction')),
            'channel' => 'MOBILE_MONEY,WALLET',
            'customer_name' => $user->name,
            'customer_email' => $user->email,
        ];

        // Run the request
        $http = new HttpClient();
        $response = $http->acceptJson()->post(
            app_env('CINETPAY_PAYMENT_URL'),
            array_merge($payload, $credentials)
        );

        if (! $response->statusCode() != 200) {
            return false;
        }

        $content = $response->toJson();

        $payment = $content['data'];
        $payment['status'] = 'pending';
        $payment['api_response_id'] = $content['api_response_id'];
        $payment['provider'] = 'cinetpay';

        cache()->put("deposit:$transaction", array_merge($payload, (array) $payment));

        return (object) $payment;
    }

    /**
     * Generate the Hmac Token
     */
    public function checkHmacToken(string $token, array $attributes): bool
    {
        return hash_equals($this->generateHmacToken($attributes), $token) ?:
            throw new BadRequestException(
                'The x-token is invalid'
            );
    }

    /**
     * Generate the hmac token
     */
    public function generateHmacToken(array $attributes): string
    {
        $cpm_site_id = $attributes['cpm_site_id'];
        $cpm_trans_id = $attributes['cpm_trans_id'];
        $cpm_trans_date = $attributes['cpm_trans_date'];
        $cpm_amount = $attributes['cpm_amount'];
        $cpm_currency = $attributes['cpm_currency'];
        $signature = $attributes['signature'];
        $payment_method = $attributes['payment_method'];
        $cel_phone_num = $attributes['cel_phone_num'];
        $cpm_phone_prefixe = $attributes['cpm_phone_prefixe'];
        $cpm_language = $attributes['cpm_language'];
        $cpm_version = $attributes['cpm_version'];
        $cpm_payment_config = $attributes['cpm_payment_config'];
        $cpm_page_action = $attributes['cpm_page_action'];
        $cpm_custom = $attributes['cpm_custom'] ?? '';
        $cpm_designation = $attributes['cpm_designation'];
        $cpm_error_message = $attributes['cpm_error_message'];

        $data = $cpm_site_id . $cpm_trans_id . $cpm_trans_date . $cpm_amount .
            $cpm_currency . $signature . $payment_method . $cel_phone_num . $cpm_phone_prefixe .
            $cpm_language . $cpm_version . $cpm_payment_config . $cpm_page_action . $cpm_custom .
            $cpm_designation . $cpm_error_message;

        return hash_hmac('sha256', $data, app_env('CINETPAY_SECRET'));
    }

    /**
     * Get the transaction status
     */
    public function getPaymentStatus(string $transaction): mixed
    {
        $payload = [
            'transaction_id' => $transaction,
            'apikey' => app_env('CINETPAY_KEY'),
            'site_id' => app_env('CINETPAY_SITE_ID'),
        ];

        // Run the request
        $http = new HttpClient();
        $response = $http->acceptJson()->post(
            app_env('CINETPAY_CHECK_URL'),
            $payload
        );

        if (! $response->statusCode() || $response->statusCode() != 200) {
            return false;
        }

        $data = $response->toJson();

        $transaction = $data['data'] ?? [];
        $transaction['status'] = $transaction['status'] === 'ACCEPTED' ? 'success' : 'failed';
        $transaction['api_response_id'] = $data['api_response_id'];

        return (object) $transaction;
    }
}
