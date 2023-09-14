<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username')
            ->add('firstname')
            ->add('phone')
            ->add('email')
            //->add('password')
            //->add('isAdmin')
            //->add('isRegisteredToEvent')
            ->add('pseudo')

            //->add('roles')
            // MC: attention il faudra l'ajouter ->add('schoolsite')
            //  MC: attention il faudra l'ajouter ->add('photo')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
