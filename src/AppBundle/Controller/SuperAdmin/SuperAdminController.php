<?php
/**
 * Created by PhpStorm.
 * User: Aafke
 * Date: 20/09/16
 * Time: 13:44
 */

namespace AppBundle\Controller\SuperAdmin;


use AppBundle\Entity\User;
use AppBundle\Form\EditUserRoleForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SuperAdminController extends Controller
{
    /**
     * @Route("/superadmin/{user}", name="superadmin")
     */
    public function addRoleToUserAction(Request $request, User $user)
    {
        $form = $this->createForm(EditUserRoleForm::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Deze gebruiker heeft een nieuwe rol. Supercool!');

            return $this->redirectToRoute('admin_home');
        }

        return $this->render('superAdmin/add_role.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    /**
     * @Route("/superadmin", name="superadmin_users")
     */
    public function listAction(){
        $users = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->findAll();

        return $this->render('superAdmin/list_users.html.twig', array(
            'users' => $users
        ));
    }
}