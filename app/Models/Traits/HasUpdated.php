<?php

namespace App\Models\Traits;

trait HasUpdated
{
    /**
     * Check if the element have been updated
     *
     * @return bool
     */
    public function isEdited(): bool
    {
        return $this->updated_at->greaterThan($this->created_at);
    }
}
