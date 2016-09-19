<?php
/**
 * Created by PhpStorm.
 * User: Aafke
 * Date: 19/09/16
 * Time: 11:27
 */

namespace Repository;

use AppBundle\Entity\Folder;
use Doctrine\ORM\EntityRepository;

/**
 * Class FolderRepository
 * @return Folder[]
 */
class FolderRepository extends EntityRepository
{
    public function findAllRecentFolders()
    {
        return $this->createQueryBuilder('folder')
            ->getQuery()
            ->execute();
    }

}