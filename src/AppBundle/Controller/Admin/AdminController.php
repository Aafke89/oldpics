<?php
/**
 * Created by PhpStorm.
 * User: Aafke
 * Date: 20/09/16
 * Time: 13:14
 */

namespace AppBundle\Controller\Admin;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin_home")
     */
    public function adminHomeAction()
    {
        return $this->render('admin/home.html.twig');
    }

}