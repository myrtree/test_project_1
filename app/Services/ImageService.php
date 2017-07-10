<?php

namespace Services;

class ImageService
{
    public function resize(string $fileName)
    {
        $imageHandler = null;
        list (
            $originalWidth,
            $originalHeight,
            $sourceType
        ) = getimagesize($fileName);
        $newWidth = 320;
        
        switch ($sourceType) {
            case IMAGETYPE_GIF:
                $imageHandler = imagecreatefromgif($fileName);
                break;
            case IMAGETYPE_JPEG:
                $imageHandler = imagecreatefromjpeg($fileName);
                break;
            case IMAGETYPE_PNG:
                $imageHandler = imagecreatefrompng($fileName);
                break;
            default:
                // nuffing
                return false;
                break;
        }

        if (!$imageHandler) {
            return false;
        }

        // $ratio  = $newWidth / $originalWidth;
        // $newHeight = $originalHeight * $ratio;
        // imagescale($imageHandler, $newWidth, $newHeight);

        $scaledImageHandler = imagescale($imageHandler, $newWidth, -1);
        imagejpeg($scaledImageHandler, $fileName);
        imagedestroy($imageHandler);
        imagedestroy($scaledImageHandler);

        return $scaledImageHandler;
    }

    public function moveUploaded()
    {
        if (!$_FILES['pic']['size'] ?? false) {
            return false;
        }

        $fileExt = pathinfo($_FILES['pic']['name'], PATHINFO_EXTENSION);
        $fileName = sprintf('./uploads/%s.%s', sha1_file($_FILES['pic']['tmp_name']), $fileExt);
        move_uploaded_file($_FILES['pic']['tmp_name'], $fileName);

        return $fileName;
    }
}
