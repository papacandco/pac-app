<?php

namespace App\Models;

use Bow\Database\Barry\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Material extends Model
{
    use SoftDeletes;

    /**
     * The mass assignable columns
     *
     * @var array
     */
    protected $fillable = ['description', 'path', 'filename', 'filesize', 'mimetype', 'extension'];

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
