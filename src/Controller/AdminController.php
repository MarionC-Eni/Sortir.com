<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\State;
use App\Entity\Campus;
use App\Form\EventType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\EditProfileFormType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Security;
use App\Service\EventStateService\EventStateService;
use App\Repository\EventRepository;
use App\Repository\LocationRepository;


class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }



    #[Route('/admin/ville', name: 'app_admin_ville')]
    public function gestionville(LocationRepository $LocationRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        
        $form = $this->createForm(EventType::class, $Location);//mettre LocationType a la place de Eventtype quand ca sera créé
        //$form->handleRequest($request);

        return $this->render('admin/ville.html.twig', [
            //'event' => $event,
            'form' => $form,
        ]);
    }
}