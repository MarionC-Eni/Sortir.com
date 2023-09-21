<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\Campus;
use App\Entity\Event;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class EventFilterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->setMethod('get')

            ->add('schoolsite', EntityType::class, [
                'label' => 'Campus ',
                'class' => Campus::class,
                'choice_label' => 'name',
                'required' => false,
            ])

            ->add('min_date', DateType::class, [
                'label' => 'Entre le',
                'html5' => false,
                'widget' => 'single_text',
//                // mc: rajouter plus tard du javascript pour gérer le calendrier
//                'attr' => ['class' => 'datepicker'],
                'format' => 'dd/MM/yyyy'
            ])

            ->add('max_date', DateType::class, [
                'label' => 'et le',
// MC : à voir si on laisse la possibilité à l'utilisateur de saisir manuellement une date au format texte
                'html5' => false,
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy'
            ])


            ->add('eventorgenazedby', CheckboxType::class, [
                'label' => "Sorties dont je suis l'organisateur/trice",
                'required' => false,
            ])

            ->add('registered', CheckboxType::class, [
                'label' => "Sorties auxquelles je suis inscrit/e",
                'required' => false,
            ])

            ->add('not_registered', CheckboxType::class, [
                'label' => "Sorties auxquelles je ne suis pas inscrit/e",
                'required' => false,
            ])

            ->add('past_event', CheckboxType::class, [
                'label' => "Sorties passées",
                'required' => false,
            ])

            ->add('submit', SubmitType::class, ['label' => 'Filtrer'])

        ;
    }

    //->add('idEvent')
//            ->add('name', TextType::class, ['label' => 'Intitulé : '])
//            ->add('dateHourStart')
//            ->add('duration')
//            ->add('dateLimitInscription')
//            ->add('NbInscriptionsMax')
//
////            ->add('eventorgenazedby', EntityType::class, [
////                'label' => 'Organisé par : ',
////                'class' => User::class, // Entité cible
////                'choice_label' => 'username', // Propriété à afficher dans la liste déroulante
////                'multiple' => false, // Permettre la sélection multiple
////            ])

//            ->add('infosEvent')
////            ->add('ReasonCancellation')

    public function configureOptions(OptionsResolver $resolver): void
    {
//        $resolver->setDefaults([
//            'data_class' => Event::class,
//        ]);

        $resolver->setDefaults([
            'data_class' => null, // Allow array as view data
        ]);

    }

    private function createFormBuilder($searchData)
    {
    }
}
