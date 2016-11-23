<?php
/**
 * Created by PhpStorm.
 * User: Aafke
 * Date: 19/09/16
 * Time: 09:53
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function homepageAction()
    {
        $authChecker = $this->get('security.authorization_checker');
        $request = $this->container->get('request_stack')->getMasterRequest();
        $ip_whitelist = $this->container->getParameter('ip_whitelist');

        if ($authChecker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin_home');
        } elseif ($authChecker->isGranted('ROLE_SUPEROPA')
            or $request->getClientIp() == $ip_whitelist
        ) {
            return $this->redirectToRoute('all_folders');
        } elseif ($authChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('new_user');
        }

        // User doesn't have permission to be here.
        return $this->redirectToRoute('user_login');
    }
}