<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditUserRoleForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('roles', ChoiceType::class, [
                'multiple' => true,
                'expanded' => true,
                'choices' => [
                    'Admin' => 'ROLE_ADMIN',
                    'SuperAdmin' => 'ROLE_SUPERADMIN',
                    'Opa en Oma' => 'ROLE_SUPEROPA',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getName()
    {
        return 'app_bundle_edit_user_form_type';
    }
}
