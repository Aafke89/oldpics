<?php

/**
 * Created by PhpStorm.
 * User: Aafke
 * Date: 19/09/16
 * Time: 09:58
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Photo
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PhotoRepository")
 * @ORM\Table(name="photo")
 */
class Photo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $title = null;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     */
    private $description = null;

    /**
     * @ORM\Column(type="string")
     * @Assert\File(
     *     maxSize = "2048k",
     *     mimeTypes = {"image/jpeg", "image/png"},
     *     mimeTypesMessage = "Please upload a valid image"
     * )
     *
     */
    private $file;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Folder", inversedBy="photos")
     * @Assert\NotBlank()
     */
    private $folder;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="photo")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $user;

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return mixed
     */
    public function getFolder()
    {
        return $this->folder;
    }

    /**
     * @param mixed $folder
     */
    public function setFolder($folder)
    {
        $this->folder = $folder;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }




}