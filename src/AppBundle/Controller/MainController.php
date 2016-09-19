<?php
/**
 * Created by PhpStorm.
 * User: Aafke
 * Date: 19/09/16
 * Time: 09:53
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function homepageAction()
    {
        $em = $this->getDoctrine()->getManager();
        $folders = $em->getRepository('AppBundle:Folder')
            ->findAll();
        return $this->render('main/homepage.html.twig',[
            'folders' => $folders,
    ]);
    }
}