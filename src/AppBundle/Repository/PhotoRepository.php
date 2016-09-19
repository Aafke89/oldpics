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
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class PhotoRepository
 * @return Photo[]
 */
class PhotoRepository extends EntityRepository
{
    public function findAllPhotosFromFolder(Folder $folder, $currentPage = 1)
    {
        return  $this->createQueryBuilder('photo')
            ->andWhere('photo.folder = :folder')
            ->setParameter('folder', $folder)
            ->getQuery()
            ->execute()
        ;

//        $paginator = $this->paginate($query, $currentPage);
//
//    return $paginator;
    }

//    public function paginate($query, $page = 1, $limit = 1)
//    {
//        $paginator = new Paginator($query);
//        $paginator->getQuery()
//            ->setFirstResult($limit * ($page - 1))
//            ->setMaxResults($limit);
//        return $paginator;
//    }

}