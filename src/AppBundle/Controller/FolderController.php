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

class FolderController extends Controller
{
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
}