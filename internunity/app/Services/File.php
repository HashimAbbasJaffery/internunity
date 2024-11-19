<?php

namespace App\Services;

use Storage;

class File
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {}

    public function upload($file, $fileType = 'public', $path = "/projects/") {
        if($file) {
            $fileName = time() . "." . $file->extension();
            Storage::disk($fileType)->putFileAs($path, $file, $fileName);
            return $fileName;
        }
        return null;
    }
    public function replace($deletingFileName, $uploadingFile, $fileType = 'public', $path = '/projects/') {
        if(Storage::disk($fileType)->exists("{$path}{$deletingFileName}")) {
            Storage::disk($fileType)->delete("{$path}{$deletingFileName}");
        }
        return $this->upload($uploadingFile);
    }

}
