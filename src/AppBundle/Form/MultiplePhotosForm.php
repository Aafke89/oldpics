<?php

namespace AppBundle\Form;

use AppBundle\Entity\Folder;
use Faker\Provider\File;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MultiplePhotosForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('files', FileType::class, [
                'multiple' => true,
                'data_class' => null,
            ])
            ->add('folder', EntityType::class, [
                'class' => Folder::class
            ])
        ;;
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getName()
    {
        return 'app_bundle_multiple_photos_form';
    }
}
