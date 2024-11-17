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

    public function upload($file, $fileType = 'public') {
        if($file) {
            $fileName = time() . "." . $file->extension();
            Storage::disk($fileType)->putFileAs("/projects/", $file, $fileName);
            return $fileName;
        }
        return null;
    }
    public function replace($deletingFileName, $uploadingFile, $fileType = 'public') {
        if(Storage::disk($fileType)->exists("/projects/$deletingFileName")) {
            Storage::disk($fileType)->delete("/projects/$deletingFileName");
        }
        return $this->upload($uploadingFile);
    }

}
