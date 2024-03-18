<?php

namespace App\Traits;


use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait ImageUploadTrait
{
    public function uploadImages($imageData,   $storagePath)
    {
        $imageData = str_replace(chr(0), '', $imageData);
        $image_parts = explode(";base64,", $imageData);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);


        // Save the image to the file system.
        $fileName = uniqid() . '.'. $image_type;

        if ($storagePath) {
            $storagePath = public_path('uploads/' . $storagePath);
            if (!File::exists($storagePath)) {
                File::makeDirectory($storagePath, 0777, true, true);
            }
        }

        $filePath = $storagePath . '/' . $fileName;
        file_put_contents($filePath, $image_base64);

        // Return the image path.
        return ['url' => Storage::url($filePath),'imageName'=>$fileName];
    }
}