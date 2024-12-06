<?php

namespace App\Services;

use Bow\Http\Request;

class IpGeolocationService
{
    /**
     * The base api url
     *
     * @var string
     */
    public const BASE_API_URL = 'https://api.ipgeolocation.io/ipgeo?apiKey=';

    /**
     * The response fields
     *
     * @var array
     */
    private $fields = [];

    /**
     * The excludes response fields
     *
     * @var array
     */
    private $excludes = [];

    /**
     * Get the IP geo location
     *
     * @return mixed
     */
    public function locate($ip = null): mixed
    {
        if (is_null($ip)) {
            $ip = Request::getInstance()->ip();
        }

        $url = $this->buildUrl($ip);

        $client = new \GuzzleHttp\Client;

        try {
            $response = $client->request('GET', $url);
        } catch (\Exception $e) {
            return null;
        }

        $response = (string) $response->getBody();

        return json_decode($response);
    }

    /**
     * Build ip url
     *
     * @param  string  $ip
     * @return string
     */
    private function buildUrl($ip): string
    {
        $query_string = '';

        if (count($this->fields) > 0) {
            $query_string = '&fields='.implode(',', $this->fields);
        }

        if (count($this->excludes) > 0) {
            $query_string = '&excludes='.implode(',', $this->excludes);
        }

        return static::BASE_API_URL.app_env('IP_GEOLOCATION_SECRET').'&ip='.$ip.$query_string;
    }

    /**
     * Get the excludes fields
     *
     * @return void
     */
    public function excludes(array $excludes): void
    {
        $this->excludes = array_merge($this->fields, $excludes);
    }

    /**
     * The list of the response fields
     *
     * @return void
     */
    public function fields(array $fields): void
    {
        $this->fields = array_merge($this->fields, $fields);
    }
}
