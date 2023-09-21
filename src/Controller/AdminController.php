<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\State;
use App\Entity\Campus;
use App\Entity\City;
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
use Symfony\Component\Form\DataTransformerInterface;
use App\Form\EditeCityType;
use App\Repository\CityRepository;


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
    public function gestionville(CityRepository $cityRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $city = $cityRepository->findAll();
        //dd($city);
       // $form = $this->createForm(EditeCityType::class, $city);//mettre LocationType a la place de Eventtype quand ca sera créé
        //$form->handleRequest($request);

        return $this->render('admin/ville.html.twig', [
            //'form' => $form->createView(),
            'city' => $city,
        ]);
    }
}