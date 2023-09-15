<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Campus;
use App\Form\EventType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/event')]
class EventController extends AbstractController
{
    #[Route('/', name: 'app_event_index', methods: ['GET'])]
    public function index(EventRepository $eventRepository, Request $request, EntityManagerInterface $entityManager): Response
    {

//        {
//            // Créez un formulaire pour sélectionner le campus
//            $form = $this->createFormBuilder()
//                ->add('campus', ChoiceType::class, [
//                    'label' => 'Choisir son campus:',
//                    'choices' => $entityManager->getRepository(Campus::class)->findAll(),
//                    'choice_label' => 'name',
//                    'required' => false, // pour permettre la sélection de "Tous les campus"
//                ])
//                ->add('filter', SubmitType::class, ['label' => 'Filtrer'])
//                ->getForm();
//
//            $form->handleRequest($request);
//
//            $selectedCampus = $form->get('campus')->getData();
//
//            $queryBuilder = $entityManager->createQueryBuilder()
//                ->select('e')
//                ->from('App\Entity\Event', 'e');
//
//            if ($selectedCampus) {
//                $queryBuilder
//                    ->andWhere('e.schoolsite = :selectedCampus')
//                    ->setParameter('selectedCampus', $selectedCampus);
//            }
//
//            $events = $queryBuilder->getQuery()->getResult();
//
//            return $this->render('event/index.html.twig', [
//                'events' => $events,
//                'form' => $form->createView(), // Passer le formulaire au template
//            ]);
//        }
//    }


//        $idcampus = 1; // nantes
//
//        $events = $eventRepository->findEventsByCampus($idcampus);
//
//        return $this->render('event/index.html.twig', [
//            'events' => $events,
//        ]);

        return $this->render('event/index.html.twig', [
            'events' => $eventRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_event_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $event->setEventorgenazedby($this->getUser());

//            $organizer = $form->get('eventorgenazedby')->getData();
//
//            // Assurez-vous que l'organisateur a des rôles valides
//            if (empty($organizer->getRoles())) {
//                $organizer->setRoles(['ROLE_USER']);
//            }
//
//            // Enregistrez l'événement avec l'organisateur
//            $event->setEventorgenazedby($organizer);


            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
        }



        return $this->render('event/new.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_event_show', methods: ['GET'])]
    public function show(Event $event): Response
    {
        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_event_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Event $event, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('event/edit.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_event_delete', methods: ['POST'])]
    public function delete(Request $request, Event $event, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$event->getId(), $request->request->get('_token'))) {
            $entityManager->remove($event);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
    }
}
