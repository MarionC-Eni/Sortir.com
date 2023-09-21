<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Campus;

class EditProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', null, [
                'label' => 'Nom',
            ])

            ->add('firstname', null, [
                'label' => 'Prenom',
            ])

            ->add('phone', null, [
                'label' => 'Téléphone',
            ])

            ->add('email', null, [
                'label' => 'Email',
            ])

            //->add('password')
            //->add('isAdmin')
            //->add('isRegisteredToEvent')

            ->add('pseudo')

            ->add('mycampus', ChoiceType::class, [
                'choices' => [
                    'Nantes' => 'Nantes',
                    'Niort' => 'Niort',
                    'Quimper' => 'Quimper',
                    'Rennes' => 'Rennes',
                ],
                'label' => 'École de rattachement',
                'placeholder' => 'Sélectionnez une ville',
            ])


//            ->add('mycampus', null, [
//                'label' => 'Ecole de rattachement',
//            ])

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
