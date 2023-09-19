<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\State;
use App\Entity\Campus;
use App\Form\EventFilterFormType;
use App\Form\EventType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\EventStateService\EventStateService;

#[Route('/event')]
class EventController extends AbstractController
{
    #[Route('/', name: 'app_event_index', methods: ['GET'])]
    public function index(EventRepository $eventRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
//MC: revenir à cette version avant si pb avec le formulaire des filters
//        return $this->render('event/index.html.twig', [
//            'events' => $eventRepository->findAll(),
//        ]);
//    }

        $searchData = [
            'min_date' => new \DateTime("- 1 month"),
            'max_date' => new \DateTime("+ 1 year"),
//MC : on ne rajoute pas ici de quoi aller filtrer selon le schooliste
            'eventorgenazedby' => true,
        ];

        $filterForm = $this->createForm(EventFilterFormType::class, $searchData);

        $filterForm->handleRequest($request);

        $criteria = [];

        if ($filterForm->isSubmitted() && $filterForm->isValid()) {
            $formData = $filterForm->getData();

            if ($formData['min_date']) {
                $criteria['min_date'] = $formData['min_date'];
            }

            if ($formData['max_date']) {
                $criteria['max_date'] = $formData['max_date'];
            }

            // Add campus filtering criteria
            if ($formData['schoolsite']) {
                $criteria['schoolsite'] = $formData['schoolsite'];
            }

        }

        $events = $eventRepository->findByCriteria($criteria);


        return $this->render('event/index.html.twig', [
            'filterForm' => $filterForm->createView(),
            'events' => $events,
        ]);
    }





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

    private $eventStateService;

    public function __construct(EventStateService $eventStateService)
    {
        $this->eventStateService = $eventStateService;
    }
    #[Route('/{id}/publish', name: 'app_event_publish', methods: ['GET', 'POST'])]
    public function publishEvent(Request $request, Event $event, EventStateService $eventstateservice): Response
    {

        $stateId = 2; // L'ID de l'état que vous souhaitez attribuer à l'événement
        $state = $eventstateservice->getStateById($stateId);

        if ($state->getId() == 2) {
            $this->addFlash('error', '<span class="error-flash">L\'événement a déjà été publié.</span>');

        } else {
           $eventstateservice->changeEventState($event, $state);
            $this->addFlash('success', 'L\'événement a été publié avec succès.');
        }

        return $this->redirectToRoute('app_event_show', ['id' => $event->getId()]);
    }
//        // Récupérez l'ID de l'état "Publié" depuis la base de données
//        $publishedStateId = 2;
//        // on pourra créé les autres états après
//
//        // Récupérez l'entité State correspondant à l'ID
//        $publishedState = $this->getRepository(State::class)->find($publishedStateId);
//
//        if (!$publishedState) {
//            throw $this->createNotFoundException('L\'état "Publié" n\'a pas été trouvé.');
//        }
//
//        // Appelez la méthode pour changer l'état de l'événement en utilisant l'entité State correspondant à l'ID
//        $eventstateservice->changeEventState($event, $publishedState);
//
//        $this->addFlash('success', 'L\'événement a été publié avec succès.');
//
//        return $this->redirectToRoute('app_event_show', ['id' => $event->getId()]);
//    }


//    public function publish(Event $event)
//    {
//        //vérifie que c'est bien l'roganisateur qui est en train de publier
//        if ($this->getUser() !== $event->getEventorgenazedby()) {
//            throw $this->createAccessDeniedException("Seul l'organisateur de cette sortie peut la mettre en ligne !");
//        }
//
//        //vérifie que ça peut être publié : on fera ça plus tard
//
//        $this->addFlash('success', 'La sortie est mise en ligne !');
//
//        return $this->redirectToRoute('app_subscription', ['id' => $event->getId()]);
//    }
//
//
//}


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

