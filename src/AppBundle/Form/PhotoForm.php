<?php

namespace AppBundle\Form;

use AppBundle\Entity\Folder;
use AppBundle\Repository\FolderRepository;
use Faker\Provider\File;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PhotoForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('description', TextType::class)
            ->add('file', FileType::class, [
                'data_class' => null
            ])
            ->add('folder', EntityType::class, [
                    'class' => Folder::class,
                    'query_builder' => function (FolderRepository $fr) {
                        return $fr->createQueryBuilder('f')
                                  ->leftJoin('f.photos', 'p')
                                  ->orderBy('p.createdAt', 'DESC');
                    },
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Photo',
            'csrf_protection' => false,
        ]);
    }

    public function getName()
    {
        return 'app_bundle_photo_form';
    }
}
