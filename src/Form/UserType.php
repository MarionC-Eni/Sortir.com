<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('idUser',integerType::class, ['label' => 'case a ne supprimer : '])
            ->add('pseudo', TextType::class, ['label' => 'Pseudo : '])
            ->add('name', TextType::class, ['label' => 'Nom : '])
            ->add('firstname', TextType::class, ['label' => 'Prénom : '])
            ->add('phone', IntegerType::class, ['label' => 'Téléphone : '])
            ->add('email', EmailType::class, ['label' => 'Email : '])
            ->add('password', PasswordType::class, ['label' => 'Mot de passe : '])
            ->add('photo', FileType::class, ['label' => 'Photo : '])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
