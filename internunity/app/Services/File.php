<?php

namespace App\Services;

use Storage;

class File
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected $filetype = 'public'
    )
    {}

    public function upload($file) {
        if($file) {
            $fileName = time() . "." . $file->extension();
            Storage::disk($this->filetype)->putFileAs("/projects/", $file, $fileName);
            return $fileName;
        }
        return false;
    }
}
