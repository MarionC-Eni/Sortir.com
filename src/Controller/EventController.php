<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\State;
use App\Entity\Campus;
use App\Form\EventFilterFormType;
use App\Form\EventCancelationType;
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

        $user = $this->getUser();
        $searchData = [];

//        $searchData = [
//            'min_date' => new \DateTime("- 100 month"),
//            'max_date' => new \DateTime("+ 1 year"),
//        ];

        // ici on va faire appel à notre formulaire de recherche
        $filterForm = $this->createForm(EventFilterFormType::class, $searchData);
        $filterForm->handleRequest($request);

        $criteria = [];
        $events = $eventRepository->findAll();
//        $formData = $filterForm->getData();
//        dump($formData);


        if ($filterForm->isSubmitted() && $filterForm->isValid()) {
            // ici on récupère les critères de recherche définis dans le repossitory
            $formData = $filterForm->getData();

            if ($formData['min_date']) {
                $criteria['min_date'] = $formData['min_date'];
            }

            if ($formData['max_date']) {
                $criteria['max_date'] = $formData['max_date'];
            }

            if ($formData['schoolsite']) {
                $criteria['schoolsite'] = $formData['schoolsite'];
            }

            // tentative 6 : je rajoute :
//            if ($formData['eventorgenazedby']) {
//                if ($user instanceof User) {
//                    $criteria['eventorgenazedby'] = $user;
//                }
//            }

            //tentative 2
//            if ($formData['eventorgenazedby'] === true) {
////                $user = $this->getUser();
////                $criteria['eventorgenazedby'] = $user;
//                $criteria['eventorgenazedby'] = true;
//            }

            //tentative 3
//            if ($criteria['filtreOption']) {
//                // Si la case à cocher est cochée, utilisez la méthode de recherche avec filtre
//                $resultats = $eventRepository->findByCriteria($criteria);
//            } else {
//                // Sinon, utilisez la méthode de recherche par critère par défaut
//                $resultats = $eventRepository->findByCriteria($criteria);
//            }
//

//            if ($formData['eventorgenazedby']) {
//                $events = $eventRepository->findByCriteria($criteria, $user);
//            } else {
//                $events = $eventRepository->findByCriteria($criteria);
//            }
//
//            if ($formData['userregistred']) {
//                $events = $eventRepository->findByCriteria($criteria, $user);
//            } else {
//                $events = $eventRepository->findByCriteria($criteria);
//            }

//            //ce code là fonctionne jusqu'à ligne    $events = $eventRepository->findByCriteria($criteria);
//            if ($formData['eventorgenazedby']) {
//                $criteria['eventorgenazedby'] = $user;
//            }
//
//            if ($formData['userregistred']) {
//                $criteria['userregistred'] = $user;
//            }
//
//// Utilisez le référentiel pour effectuer la recherche
//            if ($formData['eventorgenazedby'] || $formData['userregistred']) {
//                $events = $eventRepository->findByCriteria($criteria, $user);
//            } else {
//                $events = $eventRepository->findByCriteria($criteria);
//            }
//        }

            if ($formData['eventorgenazedby']) {
                $criteria['eventorgenazedby'] = $user;
            }

            if ($formData['userregistred']) {
                $criteria['userregistred'] = $user;
            }

            if ($formData['not_registered']) {
                $criteria['not_registered'] = $user;
            }


// Utilisez le référentiel pour effectuer la recherche
            if ($formData['eventorgenazedby'] || $formData['userregistred'] || $formData['not_registered']) {
                $events = $eventRepository->findByCriteria($criteria, $user);
            } else {
                $events = $eventRepository->findByCriteria($criteria);
            }
        }




// on affiche le résulstats
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
            $this->addFlash('danger', '<span class="error-flash">L\'événement a déjà été publié.</span>');

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

// pour que ce soit plus clair, précisons que delete aurait plutôt s'appeler "cancel"
    #[Route('/{id}', name: 'app_event_delete', methods: ['POST'])]
    public function delete(Request $request, Event $event, EntityManagerInterface $entityManager): Response
    {
        $dateHourStart = $event->getDateHourStart();
        $currentDate = new \DateTime();

        if ($dateHourStart > $currentDate) {
            return $this->redirectToRoute('app_event_confirm_cancellation', ['id' => $event->getId()]);
        } else {
            // Si l'événement est déjà passé, affichez un message d'erreur
            $this->addFlash('danger', 'Impossible d\'annuler cet événement : il est déjà passé');
            return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
        }
    }

#[Route('/{id}/confirm-cancellation', name: 'app_event_confirm_cancellation', methods: ['GET', 'POST'])]
public function confirmCancellation(Request $request, Event $event, EntityManagerInterface $entityManager, EventStateService $eventstateservice): Response
    {
        $form = $this->createForm(EventCancelationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Supprimez l'événement
            $entityManager->remove($event);
            $entityManager->flush();

            // Récupérez la raison d'annulation à partir du formulaire
            $reasonCancellation = $form->get('ReasonCancellation')->getData();

            $event->setReasonCancellation($reasonCancellation);

            // Vérifiez si l'état de l'événement est déjà annulé
            if ($event->getEventstate() === null || $event->getEventstate()->getId() !== 5) {
                // Si l'état n'est pas déjà annulé, annulez l'événement
                $stateId = 5; // L'ID de l'état à attribuer pour annuler l'événement
                $state = $eventstateservice->getStateById($stateId);
                $eventstateservice->changeEventState($event, $state);
                $this->addFlash('success', 'L\'événement a bien été annulé.');
            } else {
                $this->addFlash('danger', 'L\'événement est déjà annulé.');
            }

            return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
        }


        return $this->render('event/cancelation.html.twig', [
            'event' => $event,
            'cancelForm' => $form->createView()
        ]);
    }

}


//
// ce code marche mais il faut rajouter le motif d'annulation
//    {
//        $dateHourStart = $event->getDateHourStart();
//
//        $currentDate = new \DateTime();
//        if ($dateHourStart > $currentDate) {
//
//            if ($this->isCsrfTokenValid('delete'.$event->getId(), $request->request->get('_token'))) {
//                $entityManager->remove($event);
//                $entityManager->flush();
//                $this->addFlash('success', 'L\'événement a bien été annulé');}
//
//
//            else {
//                // message d'erreur si le jeton CSRF n'est pas valide
//                $this->addFlash('danger', 'Erreur de sécurité : Token CSRF invalide.');
//            }
//        } else {
//            // Si l'événement est déjà passé, affichez un message d'erreur
//            $this->addFlash('danger', 'Impossible d\'annuler cet événement : il est déjà passé');
//        }
//
//
//        return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
//    }
//}

