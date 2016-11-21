<?php
/**
 * Created by PhpStorm.
 * User: Aafke
 * Date: 19/09/16
 * Time: 16:55
 */

namespace AppBundle\Service;


use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDir;

    /** @var ContainerInterface */
    protected $container;

    public function __construct($targetDir, ContainerInterface $container)
    {
        $this->targetDir = $targetDir;
        $this->container = $container;

    }

    public function upload(UploadedFile $file)
    {
        \Cloudinary::config([
            "cloud_name" => $this->container->getParameter('cloudinary_name'),
            "api_key" => $this->container->getParameter('cloudinary_api_key'),
            "api_secret" => $this->container->getParameter('cloudinary_secret_api')
        ]);

        $cloudinary_array = \Cloudinary\Uploader::upload("$file");

        return $cloudinary_array["url"];
    }

}