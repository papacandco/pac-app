<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ErrorReport extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

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

        $this->onQueue('mailing');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = [
            'geolocation' => (new \App\Services\IpGeolocationService)->locate($this->data['ip']),
        ];

        // Merge data
        $data = array_merge($data, $this->data);

        return $this->view('mail.error-report', $data)
            ->to('admin@codelearningclub.com')
            ->subject('Papac & Co - Error Reporting ('.date('d/m/Y H:i:s').')');
    }
}
