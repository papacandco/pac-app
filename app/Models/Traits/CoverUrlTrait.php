<?php

namespace App\Models\Traits;

trait CoverUrlTrait
{
    /**
     * Cover mutation
     *
     * @return string
     */
    public function getCover()
    {
        if (preg_match('/^\/img/', $this->cover) || preg_match('/^https?:\/\//', $this->cover)) {
            return $this->cover;
        }

        if (in_array(app_env('APP_ENV'), ['production', 'staging'])) {
            return app_env('AWS_URL') . '/' . $this->cover;
        }

        return '/storage/' . trim($this->cover, '/');
    }

    /**
     * Cover mutation
     *
     * @return string
     */
    public function getSource()
    {
        if (preg_match('/^\/img/', $this->source) || preg_match('/^https?:\/\//', $this->source)) {
            return $this->source;
        }

        if (in_array(app_env('APP_ENV'), ['production', 'staging'])) {
            return app_env('AWS_URL') . '/' . $this->source;
        }

        return '/storage/' . trim($this->source, '/');
    }
}
