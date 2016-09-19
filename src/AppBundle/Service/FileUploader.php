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
        $extension = $file->guessExtension();
        $fileName = md5(uniqid()).'.'.$extension;

        $file->move(
            $this->targetDir, $fileName );

        return $fileName;
    }

}