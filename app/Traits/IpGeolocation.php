<?php

namespace App\Traits;

use App\Services\IpGeolocationService as AppIpGeolocationService;

trait IpGeolocation
{
    /**
     * Get the IP geo location
     *
     * @return array
     */
    public function getIpGeolocationService($ip = null)
    {
        return (new AppIpGeolocationService)->locate($ip);
    }
}
