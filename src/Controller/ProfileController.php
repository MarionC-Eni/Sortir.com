<?php

namespace App\Controller;

use App\Form\EditProfileFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Security;


class ProfileController extends AbstractController
{

    #[Route(path: '/profile', name: 'app_show_profile')]
    public function profile(UserRepository $userRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Obtenez l'utilisateur actuellement connecté
//        $user = $security->getUser();

        //$em = $this->getDoctrine()->getManager();
        //récupère le user en session
        //ne jamais récupérer le user en fonction de l'id dans l'URL !
        $user = $this->getUser();


        // Obtenez l'ID de l'utilisateur connecté
        $userId = $user->getId();

        // Utilisez l'ID pour récupérer l'utilisateur depuis le repository
        $profileUser = $userRepository->find($userId);

        if (!$profileUser) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }


        $form = $this->createForm(EditProfileFormType::class, $user);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            // Si le formulaire est soumis et valide, enregistrez les modifications dans la base de données

            $entityManager->persist($user);
            $entityManager->flush($user);

            // Redirigez l'utilisateur vers une autre page ou affichez un message de succès
            return $this->redirectToRoute('app_home');
        }

        return $this->render('profile/editprofile.html.twig', [
            'user' => $profileUser,
            'form' => $form->createView(),
        ]);

//        return $this->render('profile/editprofile.html.twig', [
//            'registrationFormType' => $form->createView(),
//        ]);
    }


    }


