<?php

namespace App\Controllers\Traits;

use App\Models\Material;
use Bow\Http\UploadedFile;

trait UploadedFileTrait
{
    /**
     * Upload the cover
     *
     * @param  UploadedFile $cover
     * @param  string       $to
     * @param  string       $prefix_name
     * @return string
     */
    protected function uploadMaterial(UploadedFile $cover, string $to, $prefix_name = null, $description = 'N/A')
    {
        if (is_null($cover)) {
            return null;
        }

        if (! $cover->isUploaded()) {
            return null;
        }

        if (is_null($prefix_name)) {
            $prefix_name = '';
        } else {
            $prefix_name = '_' . $prefix_name;
        }

        // Build the filename
        $filename = md5(microtime(false)) . $prefix_name . '.' . $cover->extension();

        $path = $cover->moveTo($to, $filename);

        $this->saveUploadedMaterialDetails($cover, $path, $description);

        return $path;
    }

    /**
     * Create the materials
     *
     * @param  UploadedFile $path
     * @param  string       $path
     * @return mixed
     */
    private function saveUploadedMaterialDetails(UploadedFile $file, $path, $description = 'N/A')
    {
        Material::create([
            'description' => $description,
            'path' => $path,
            'filename' => $file->getFilename(),
            'extension' => $file->getExtension(),
            'filesize' => $file->getFilesize(),
            'mimetype' => $file->getTypeMime(),
        ]);
    }

    /**
     * Delete the materiel entry
     *
     * @param string $path
     */
    public function deleteMaterialEntry($path)
    {
        @Material::wherePath($path)->delete();
    }
}
