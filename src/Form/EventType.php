<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\Campus;
use App\Entity\Event;
use App\Entity\User;
use Doctrine\DBAL\Types\DateType;
use phpDocumentor\Reflection\Types\Array_;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;




class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //->add('idEvent')
            ->add('name', TextType::class, ['label' => 'Intitulé : '])
            ->add('dateHourStart', DateTimeType::class, ['label' => 'Date et heure de début : '])
            ->add('duration', TimeType::class, ['label' => 'Durée : '])
            ->add('dateLimitInscription', DateTimeType::class, ['label' => 'Date limite d\'inscription : '])
            ->add('NbInscriptionsMax', IntegerType::class, ['label' => 'Inscription max : '])

//            ->add('eventorgenazedby', EntityType::class, [
//                'label' => 'Organisé par : ',
//                'class' => User::class, // Entité cible
//                'choice_label' => 'username', // Propriété à afficher dans la liste déroulante
//                'multiple' => false, // Permettre la sélection multiple
//            ])

            ->add('infosEvent',TextType::class, ['label' => 'Description : '])
//            ->add('ReasonCancellation')
            ->add('locationevent', EntityType::class, [
                'label' => 'Lieu de l\'événement',
                'class' => Location::class,
                'choice_label' => 'name'
            ])
            ->add('schoolsite', EntityType::class, [
                'label' => 'Votre école de rattachement',
                'class' => Campus::class,
                'choice_label' => 'name'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
