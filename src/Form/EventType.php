<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Event;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //->add('idEvent')
            ->add('name')
            ->add('dateHourStart')
            ->add('duration')
            ->add('dateLimitInscription')
            ->add('NbInscriptionsMax')
            ->add('infosEvent')
            ->add('ReasonCancellation')
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
