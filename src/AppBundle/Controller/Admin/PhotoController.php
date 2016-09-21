<?php
/**
 * Created by PhpStorm.
 * User: Aafke
 * Date: 19/09/16
 * Time: 15:15
 */

namespace AppBundle\Controller\Admin;


use AppBundle\Form\FolderForm;
use AppBundle\Form\PhotoForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PhotoController extends Controller
{
    /**
     * @Route("admin/new/photo", name="add_photo")
     */
    public function AddPhotoAction(Request $request)
    {
//        $photo = new Photo();
        $form = $this->createForm(PhotoForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $photo = $form->getData();

//            Add the file to web/uploads
            $file = $photo->getFile();
            $fileName = $this->get('app.photo_uploader')->upload($file);
            $photo->setFile($fileName);

//            Add the time that the photo is added
            $now = new\DateTime('now');
            $photo->setCreatedAt($now);

//            Add the user that uploaded this photo
            $user = $this->getUser();
            $photo->setUser($user);

//            dump($photo);die;

            $em = $this->getDoctrine()->getManager();
            $em->persist($photo);
            $em->flush();

            $this->addFlash('success', 'Gelukt! Deze foto is nu zichtbaar voor opa en oma! Nog eentje?');

            return $this->redirectToRoute('add_photo');
        }

        return $this->render('admin/newphoto.html.twig', [
            'form' => $form->createView()
        ]);
    }
}