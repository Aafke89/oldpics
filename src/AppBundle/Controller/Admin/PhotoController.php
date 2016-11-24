<?php
/**
 * Created by PhpStorm.
 * User: Aafke
 * Date: 19/09/16
 * Time: 15:15
 */

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Photo;
use AppBundle\Form\FolderForm;
use AppBundle\Form\MultiplePhotosForm;
use AppBundle\Form\PhotoForm;
use AppBundle\Security\UserVoter;
use Monolog\ErrorHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

class PhotoController extends Controller
{
    /**
     * @Route("admin/photo/new", name="add_photo")
     */
    public function AddPhotoAction(Request $request)
    {
        //        $photo = new Photo();
        $form = $this->createForm(PhotoForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photo = $form->getData();

            // Add the file to web/uploads

            $file = $photo->getFile();
            if ($file == null) {
                $form->get('file')->addError(new FormError('Voeg een foto toe'));
                return $this->render(
                    'admin/newphoto.html.twig', [
                        'form' => $form->createView(),
                    ]
                );
            }
            $fileName = $this->get('app.photo_uploader')->upload($file);
            $photo->setFile($fileName);


            // Add the time that the photo is added
            $now = new\DateTime('now');
            $photo->setCreatedAt($now);

            // Add the user that uploaded this photo
            $user = $this->getUser();
            $photo->setUser($user);

            // dump($photo);die;

            $em = $this->getDoctrine()->getManager();
            $em->persist($photo);
            $em->flush();

            $this->addFlash(
                'success',
                'Gelukt! Deze foto is nu zichtbaar voor Ger en Theo! Nog eentje?'
            );
            return $this->redirectToRoute('add_photo');
        }
        return $this->render(
            'admin/newphoto.html.twig', [
            'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("admin/photo/{photo}/edit", name="edit_photo")
     */
    public function EditPhotoAction(Request $request, Photo $photo)
    {
        //      use the UserVoter to check if this is the creator of the foto
        $this->denyAccessUnlessGranted(UserVoter::EDIT, $photo);

        // Keep the file!
        $file = $photo->getFile();

        $form = $this->createForm(PhotoForm::class, $photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photo = $form->getData();

            // Add the time that the photo is updated
            $now = new\DateTime('now');
            $photo->setCreatedAt($now);
            $photo->setFile($file);

            $em = $this->getDoctrine()->getManager();
            // $em->persist($photo);
            $em->flush();

            $this->addFlash('success', 'Gelukt! Deze foto is nu bewerkt');

            return $this->redirectToRoute(
                'folder_show', [
                'folderId' => $photo->getFolder()->getId()
                ]
            );
        }

        return $this->render(
            'admin/editPhoto.html.twig', [
            'form' => $form->createView(),
            'photo' => $photo
            ]
        );
    }

    /**
     * @Route("admin/photo/{photo}/delete", name="delete_photo")
     */
    public function deletePhotoAction(Request $request, Photo $photo)
    {
        //      use the UserVoter to check if this is the creator of the foto
        $this->denyAccessUnlessGranted(UserVoter::DELETE, $photo);

        $em = $this->getDoctrine()->getManager();
        $em->remove($photo);
        $em->flush();

        $this->addFlash('success', 'Gelukt je hebt deze foto verwijderd');

        return $this->redirectToRoute('all_folders');
    }

    /**
     * @Route("admin/multiphotos/new", name="add_multiple_photos")
     */
    public function AddMultiplePhotosAction(Request $request)
    {
        $form = $this->createForm(MultiplePhotosForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $files = $data['files'];
            $folder = $data['folder'];
            $now = new\DateTime('now');
            $user = $this->getUser();

            foreach ($files as $file) {
                $photo = new Photo();
                $fileName = $this->get('app.photo_uploader')->upload($file);
                $photo->setFile($fileName);
                $photo->setFolder($folder);
                $photo->setCreatedAt($now);
                $photo->setUser($user);

                $em = $this->getDoctrine()->getManager();
                $em->persist($photo);
                $em->flush();
            }

            $this->addFlash(
                'success',
                'Gelukt! Deze foto\'s zijn nu zichtbaar voor Ger en Theo! Nog eentje?'
            );

            return $this->redirectToRoute('admin_home');
        }
        return $this->render(
            'admin/multiplephotos.html.twig',
            ['form' => $form->createView(), ]
        );
    }
}
