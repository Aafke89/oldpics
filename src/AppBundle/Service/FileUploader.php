<?php
/**
 * Created by PhpStorm.
 * User: Aafke
 * Date: 19/09/16
 * Time: 16:55
 */

namespace AppBundle\Service;


use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDir;

    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;

    }

    public function upload(UploadedFile $file)
    {
        \Cloudinary::config([
            "cloud_name" => "hqpsx2eiv",
            "api_key" => "991218623932461",
            "api_secret" => "5_cjYYcO6wm1if2HotsZ57QGAzs"
        ]);

        $extension = $file->guessExtension();
        $fileName = md5(uniqid()).'.'.$extension;

        $cloudinary_array = \Cloudinary\Uploader::upload("$file");

//
//        $file->move(
//            $this->targetDir, $fileName );



        return $cloudinary_array["url"];
    }

}