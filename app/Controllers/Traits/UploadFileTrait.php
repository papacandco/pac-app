<?php

namespace App\Controllers\Traits;

use App\Jobs\ImageCompressorJob;
use App\Models\Material;
use Illuminate\Http\UploadedFile;

trait UploadFileTrait
{
    /**
     * Upload the cover
     *
     * @param  UploadedFile  $cover
     * @param  string  $to
     * @param  callable  $callable
     * @param  string  $prefix_name
     * @return string
     */
    protected function uploadMaterial($cover, $to, $prefix_name = null, $description = 'N/A')
    {
        if (is_null($cover)) {
            return null;
        }

        if (! $cover->isValid()) {
            return null;
        }

        if (is_null($prefix_name)) {
            $prefix_name = '';
        } else {
            $prefix_name = '_'.$prefix_name;
        }

        // Build the filename
        $filename = md5(microtime(false)).$prefix_name.'.'.$cover->extension();

        $path = $cover->storePubliclyAs($to, $filename);

        $this->saveUploadedMaterialDetails($cover, $path, $description);

        return $path;
    }

    /**
     * Create the materials
     *
     * @param  UploadedFile  $path
     * @param  string  $path
     * @return mixed
     */
    private function saveUploadedMaterialDetails(UploadedFile $file, $path, $description = 'N/A')
    {
        Material::create([
            'description' => $description,
            'path' => $path,
            'filename' => $file->getClientOriginalName(),
            'extension' => $file->getClientOriginalExtension(),
            'filesize' => $file->getSize(),
            'mimetype' => $file->getClientMimeType(),
        ]);

        if (app_env('APP_ENV') == 'production') {
            dispatch(new ImageCompressorJob($path));
        }
    }

    /**
     * Delete the materiel entry
     *
     * @param  string  $path
     */
    public function deleteMaterialEntry($path)
    {
        @Material::wherePath($path)->delete();
    }
}
