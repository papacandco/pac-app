<?php

namespace App\Producers;

use Bow\Mail\Mail;
use Bow\Queue\ProducerService;

class ErrorReportProducer extends ProducerService
{
    /**
     * The data
     *
     * @var array
     */
    private $data;

    /**
     * ErrorReport instance
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return void
     */
    public function process(): void
    {
        $data = [
            'geolocation' => (new \App\Services\IpGeolocationService())->locate($this->data['ip']),
        ];

        // Merge data
        $data = array_merge($data, $this->data);
        $content = view('mail.error-report', $data)->getContent();

        Mail::raw('admin@papac.dev', 'Papac & Co - Error Reporting (' . date('d/m/Y H:i:s') . ')', $content);
    }
}
