<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;


#[Route('/event')]
class SubscriptionController extends AbstractController
{
//    #[Route('/subscription', name: 'app_subscription')]
//    public function index(): Response
//    {
//        return $this->render('subscription/index.html.twig', [
//            'controller_name' => 'SubscriptionController',
//        ]);
//    }
//}
    #[Route('/subscription/{eventId}', name: 'app_subscription')]
    public function subscribeToEvent($eventId, EntityManagerInterface $entityManager)
    {

        // je recherche l'événement auquel je veux m'inscrire :
        $event = $entityManager->getRepository(Event::class)->find($eventId);;

        // pour le moment, je crée une exception très simple
        if (!$event) {
            throw $this->createNotFoundException('Événement non trouvé');
        }

        // je suis bien connectée à mon site, sinon l'inscription est impossible :
        $user = $this->getUser();

        // pour le moment, je crée une exception très simple. on vérifiera plus tard si l'utilsiateur est déjà inscrit
        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non connecté');
        }

        // WARNING : il manque PLEIN de conditions !!!

        // j'obtiens l'id de l'utilisateur connecté qui va s'inscrire à l'événement:
//        $userId = $user->getId();

//       ce code marche uniquement si on crée une nouvelle entité EventSubscription
// // je crée la nouvelle inscription à cet événement
//        $eventSubscription = new EventSubscription();
//        $eventSubscription->setUser($user);
//        $eventSubscription->setEvent($event);

        // je rajoute la condition de clôture des inscription
        $dateLimitInscription = $event->getDateLimitInscription();

        $currentDate = new \DateTime();
        if ($dateLimitInscription <= $currentDate) {
            $this->addFlash('danger', 'L\'inscription à cette sortie est clôturée');
            return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
        }

        if ($event->isEventFull()) {
            $this->addFlash("danger", "Cette sortie est complète !");
            return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
        }

//            if(isSubscribed){
//                $this->addFlash("success", "Vous êtes deja inscrit/es !");
//                }
//
//                return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);

        $user->addRegistredevent($event);


        // j'envoie mon inscription à ma base de données
//        $em->persist($eventSubscription);
        $entityManager->flush();

        $this->addFlash("success", "Vous êtes inscrit/es !");

        return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
    }

//        //on refresh la sortie pour avoir le bon nombre d'inscrits avant le tchèque ci-dessous
//        $em->refresh($event);

//        return $this->render('subscription/index.html.twig', [
//            'controller_name' => 'SubscriptionController',
//        ]);


        #[
        Route('/unsubscription/{eventId}', name: 'app_unsubscription')]
    public function unsubscribeToEvent($eventId, EntityManagerInterface $entityManager)
    {
        // je recherche l'événement auquel je veux m'inscrire :
        $event = $entityManager->getRepository(Event::class)->find($eventId);;

        // pour le moment, je crée une exception très simple
        if (!$event) {
            throw $this->createNotFoundException('Événement non trouvé');
        }

// je suis bien connectée à mon site, sinon l'inscription est impossible :
        $user = $this->getUser();

// pour le moment, je crée une exception très simple. on vérifiera plus tard si l'utilsiateur est déjà inscrit
        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non connecté');
        }

// j'obtiens l'id de l'utilisateur connecté qui va s'inscrire à l'événement:
//        $userId = $user->getId();

//       ce code marche uniquement si on crée une nouvelle entité EventSubscription
// // je crée la nouvelle inscription à cet événement
//        $eventSubscription = new EventSubscription();
//        $eventSubscription->setUser($user);
//        $eventSubscription->setEvent($event);

        $user->removeRegistredevent($event);


// j'envoie mon inscription à ma base de données
//        $em->persist($eventSubscription);
        $entityManager->flush();

//        //on refresh la sortie pour avoir le bon nombre d'inscrits avant le tchèque ci-dessous
//        $em->refresh($event);

        $this->addFlash("success", "Vous êtes désinscrit/es !");

        return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);

    }

//        return $this->render('subscription/index.html.twig', [
//            'controller_name' => 'SubscriptionController',
//        ]);



}

