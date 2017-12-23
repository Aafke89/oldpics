<?php
/**
 * Created by PhpStorm.
 * User: Aafke
 * Date: 19/09/16
 * Time: 11:27
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Folder;
use AppBundle\Entity\Photo;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class PhotoRepository
 * @param Folder $folder
 * @return Photo[]
 */
class PhotoRepository extends EntityRepository
{
    public function findAllPhotosFromFolder(Folder $folder)
    {
        return $this->findAllPhotosFromFolderQuery($folder)
            ->execute();

    }


    /**
     * @param Folder $folder
     * @return Query
     */
    public function findAllPhotosFromFolderQuery(Folder $folder)
    {
        return $this->createQueryBuilder('photo')
            ->andWhere('photo.folder = :folder')
            ->setParameter('folder', $folder)
            ->orderBy('photo.createdAt', 'DESC')
            ->addOrderBy('photo.id', 'ASC')
            ->getQuery();

    }

}