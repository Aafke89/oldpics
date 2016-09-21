<?php
/**
 * Created by PhpStorm.
 * User: Aafke
 * Date: 21/09/16
 * Time: 15:02
 */

namespace AppBundle\Controller\Admin;


use AppBundle\Entity\Folder;
use AppBundle\Form\FolderForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FolderController extends Controller
{

    /**
     * @Route("/admin/folder/all", name="admin_all_folders")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $folders = $em->getRepository('AppBundle:Folder')
            ->findAllRecentFolders();
        return $this->render(':admin:listFolders.html.twig',[
            'folders' => $folders,
        ]);
    }

    /**
     * @Route("admin/folder/new", name="add_folder")
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

    /**
     * @Route("admin/folder/{folder}/edit", name="edit_folder")
     */
    public function editFolderAction(Request $request, Folder $folder)
    {
        $form = $this->createForm(FolderForm::class, $folder);
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

            return $this->redirectToRoute('all_folders');
        }

        return $this->render('admin/newfolder.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("admin/folder/{folder}/delete", name="delete_folder")
     */
    public function deleteFolderAction(Request $request, Folder $folder)
    {

            $em = $this->getDoctrine()->getManager();
//        Delete all folders in this map
            $photos = $folder->getPhotos();
                foreach ($photos as $photo){
                    $em->remove($photo);
                }
            $em->remove($folder);
            $em->flush();

            $this->addFlash('success', 'Gelukt je hebt deze map verwijderd');

            return $this->redirectToRoute('all_folders');
    }


}