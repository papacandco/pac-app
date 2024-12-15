<?php

namespace App\Models;

use Bow\Storage\Storage;
use Bow\Database\Barry\Model;

class Material extends Model
{
    /**
     * Material constructor
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        Material::deleting(function (Material $material) {
            @Storage::delete($material->path);
        });
    }

    /**
     * __mutation
     *
     * @param  string  $value
     * @return string
     */
    public function getUrlAttribute($value)
    {
        return @Storage::url($this->path);
    }
}
