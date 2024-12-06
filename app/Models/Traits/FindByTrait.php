<?php

namespace App\Models\Traits;

trait FindByTrait
{
    /**
     * Find data by column name and value
     *
     * @param  mixed  $value
     * @return mixed
     */
    public function findBy(string $column, $value)
    {
        return $this->where($column, $value)->firstOrFail();
    }
}
