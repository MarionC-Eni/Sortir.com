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
    // #[Route('/admin/index/city', name: 'app_admin_city_index', methods: ['GET'])]

    // public function index(CityRepository $cityRepository): Response
    // {
    //     return $this->render('admin/index.html.twig', [
    //         'cities' => $cityRepository->findAll(),
    //     ]);
    // }


    #[Route('/admin/new/city', name: 'app_admin_new_city', methods: ['GET', 'POST'])]
    public function newcity (CityRepository $cityRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $city = new City();
        //$city = $cityRepository->findAll();
        //dd($city);
        $form = $this->createForm(EditeCityType::class, $city);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Si le formulaire est soumis et valide, enregistrez les modifications dans la base de données
            $entityManager->persist($city);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_new_city', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/ville.html.twig', [
            'EditeCityType' => $form->createView(),
            'city' => $city,
        ]);
    }


    // #[Route('/admin/edit/city', name: 'app_admin_edit_city', methods: ['GET', 'POST'])]
    // public function editcity (CityRepository $cityRepository, Request $request, EntityManagerInterface $entityManager): Response
    // {

    //     $city = $cityRepository->findAll();
    //     //dd($city);
       
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         // Si le formulaire est soumis et valide, enregistrez les modifications dans la base de données
    //         $entityManager->persist($city);
    //         $entityManager->flush($city);

    //         return $this->redirectToRoute('app_admin', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('admin/ville.html.twig', [
    //         'form' => $form->createView(),
    //         'city' => $city,
    //     ]);
    // }
}