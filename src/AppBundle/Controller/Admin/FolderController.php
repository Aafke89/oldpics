<?php
/**
 * Created by PhpStorm.
 * User: Aafke
 * Date: 21/09/16
 * Time: 15:02
 */

namespace AppBundle\Controller\Admin;


use AppBundle\Form\FolderForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FolderController extends Controller
{
    /**
     * @Route("admin/new/folder", name="add_folder")
     */
    public function AddFolderAction(Request $request)
    {
        $form = $this->createForm(FolderForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $folder = $form->getData();

            //      Add the user that uploaded this folder
            $user = $this->getUser();
            $folder->setUser($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($folder);
            $em->flush();

            $this->addFlash('success', 'Gelukt! Je kan nu foto\'s aan deze map toevoegen?');

            return $this->redirectToRoute('add_photo');
        }

        return $this->render('admin/newfolder.html.twig', [
            'form' => $form->createView()
        ]);
    }
}