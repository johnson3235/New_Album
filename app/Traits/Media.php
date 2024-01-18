<?php
namespace App\Traits;
use Illuminate\Support\Facades\Storage;
trait Media {
    // public static function upload($image,string $dir) :string
    // {
    //     $photoName = uniqid() . '.' . $image->extension();
    //     $image->move(public_path("images/$dir"),$photoName);
    //     return $photoName;
    // }
    public static function upload($image, string $dir): string
    {
        $photoName = uniqid() . '.' . $image->extension();
        Storage::disk('public')->put("images/$dir/$photoName", file_get_contents($image->getRealPath()));
        return $photoName;
    }

    public static function get_path($image, string $dir): string
    {
        
        return "http://127.0.0.1:8000/storage/images/$dir/$image";
    }

    public static function delete(string $filePath): bool
    {
        if (Storage::disk('private')->exists($filePath)) {
            Storage::disk('private')->delete($filePath);
            return true;
        }

        return false;

    }   
}
    // public static function delete(string $fullPublicPath) :bool
    // {
    //     $oldPhotoPath = public_path("{$fullPublicPath}");
    //     if (file_exists($oldPhotoPath)) {
    //         unlink($oldPhotoPath);
    //         return true;
    //     }
    //     return false;
    // }
