<?php

namespace App\Models\Traits;

trait CoverUrlTrait
{
    /**
     * Cover mutation
     *
     * @param  string  $value
     * @return string
     */
    public function getCoverAttribute($value)
    {
        if (preg_match('/^\/img/', $value) || preg_match('/^https?:\/\//', $value)) {
            return $value;
        }

        if (in_array(app_env('APP_ENV'), ['production', 'staging'])) {
            return app_env('AWS_URL').'/'.$value;
        }

        return '/storage/'.trim($value, '/');
    }

    /**
     * Cover mutation
     *
     * @param  string  $value
     * @return string
     */
    public function getSourceAttribute($value)
    {
        if (preg_match('/^\/img/', $value) || preg_match('/^https?:\/\//', $value)) {
            return $value;
        }

        if (in_array(app_env('APP_ENV'), ['production', 'staging'])) {
            return app_env('AWS_URL').'/'.$value;
        }

        return '/storage/'.trim($value, '/');
    }
}
