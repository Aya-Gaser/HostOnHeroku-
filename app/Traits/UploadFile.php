<?php

namespace App\Traits;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

trait UploadFile
{
    private function saveFile($file, $directory)
    {
        $extension = $file->extension();
        $fileName = time() . '' . rand(11111, 99999) . '.' . $extension;
        $saveDirectory = 'public' . '/' . $directory . '/';
        Storage::putFileAs($saveDirectory, new File($file), $fileName);
        return 'storage' . '/' . $directory . '/' . $fileName;
    }

    private function deleteFile($fileLink)
    {
        $fileLink = str_replace('storage/', 'public/', $fileLink);
        return Storage::delete($fileLink);
    }
}
