<?php
/**
 * Created by PhpStorm.
 * User: Aafke
 * Date: 19/09/16
 * Time: 11:23
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FolderController extends Controller
{
    /**
     * @Route("/folder/{folderId}", name="folder_show")
     */
    public function showAction($folderId)
    {
        $em = $this->getDoctrine()->getManager();
        $folder = $em->getRepository('AppBundle:Folder')
            ->find($folderId);
        return $this->render("folder/show.html.twig", [
            'folder' => $folder,
        ]);
    }
}