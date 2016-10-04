<?php
/**
 * Created by PhpStorm.
 * User: Aafke
 * Date: 19/09/16
 * Time: 11:23
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Folder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FolderController extends Controller
{
    /**
     * @Route("/folder/all", name="all_folders")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $folders = $em->getRepository('AppBundle:Folder')
            ->findAllRecentFolders();
        return $this->render('folder/list.html.twig', [
            'folders' => $folders,
        ]);
    }

    /**
     * @Route("/folder/{folderId}", name="folder_show")
     */
    public function showAction(Folder $folderId)
    {
        $em = $this->getDoctrine()->getManager();
        $photos = $em->getRepository('AppBundle:Photo')
            ->findAllPhotosFromFolder($folderId);

        return $this->render("folder/show.html.twig", [
            'photos' => $photos,
            'folder' => $folderId
        ]);
    }

    /**
     * @Route("/folder/{folderId}/{photo}", name="folder_photo_show")
     * @Route("/folder/{folderId}/?photo={photo}", name="folder_photo_show")
     */
    public function showPhotoAction(Request $request, Folder $folderId, $photo = 1)
    {
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('AppBundle:Photo')->createQueryBuilder('photo');
        $queryBuilder
            ->andWhere('photo.folder = :folder')
            ->setParameter('folder', $folderId)
            ->orderBy('photo.createdAt', 'DESC')
            ->getQuery()
            ->execute()
        ;

        $query = $queryBuilder->getQuery();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('photo', $photo)/*page number*/,
            $request->query->getInt('limit', 1)
        );

        return $this->render("photo/show.html.twig", [
            'photos' => $pagination,
            'folder' => $folderId
        ]);
    }
}
