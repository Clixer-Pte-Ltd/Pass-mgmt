<?php


namespace App\Services;

class ImageService
{
    public function convertBase64ToFile($value, $folder = '', $disk = 'local', $filename = null)
    {
        $destination_path = 'public/images/' . $folder;
        $srcFolder = 'storage/images/' . $folder;
        $image = \Image::make($value)->encode('jpg', 90);
        $filename = $filename ? $filename . '.jpg' : strtotime('now') . '.jpg';
        \Storage::disk($disk)->put($destination_path .'/'. $filename, $image->stream());
        $src = $srcFolder . '/' . $filename;
        return [
            'url' => url($src),
            'path' => storage_path('app/' . $destination_path .'/'. $filename)
        ];
    }
}
