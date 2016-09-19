<?php
/**
 * Created by PhpStorm.
 * User: Aafke
 * Date: 19/09/16
 * Time: 15:15
 */

namespace AppBundle\Controller\Admin;


use AppBundle\Form\PhotoForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PhotoController extends Controller
{
    /**
     * @Route("admin/new", name="add_photo")
     */
    public function AddPhotoAction(Request $request)
    {
//        $photo = new Photo();
        $form = $this->createForm(PhotoForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $photo = $form->getData();
////            file
            $file = $photo->getFile();

            $fileName = $this->get('app.photo_uploader')->upload($file);
//            $extension = $file->guessExtension();
//            $fileName = md5(uniqid()).'.'.$extension;
////            dump($fileName);die;
//            $file->move(
//                $this->getParameter('photo_directory'),
//                $fileName
//            );

            $photo->setFile($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($photo);
            $em->flush();

            $this->addFlash('success', 'Gelukt! Deze foto is nu zichtbaar voor opa en oma! Nog eentje?');

            return $this->redirectToRoute('add_photo');
        }

        return $this->render('admin/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}