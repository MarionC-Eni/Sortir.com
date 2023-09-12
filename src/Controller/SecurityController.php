<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\HttpFoundation\RedirectResponse;



class SecurityController extends AbstractController
{
    use TargetPathTrait;
    public const LOGIN_ROUTE = 'app_login';


    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

 //MC: je teste :
//    #[Route(path: '/logout', name: 'app_logout')]
//    public function logout(): void
//    {
//        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
//    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(Request $request): RedirectResponse
    {
        // Utilisez le trait TargetPathTrait pour obtenir la cible de redirection depuis la session
        $targetPath = $this->getTargetPath($request->getSession(), 'nom_de_votre_pare-feu');

        // Si une cible de redirection est définie, redirigez l'utilisateur vers cette cible
        if ($targetPath) {
            return new RedirectResponse($targetPath);
        }

        // Si aucune cible de redirection n'est définie, redirigez l'utilisateur vers une autre route, par exemple 'app_home'
        return new RedirectResponse($this->generateUrl('app_home'));
    }


}
