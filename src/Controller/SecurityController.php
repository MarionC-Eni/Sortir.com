<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;



class SecurityController extends AbstractController
{
use TargetPathTrait;
public const LOGIN_ROUTE = 'app_login';


    public function __construct(UrlGeneratorInterface $urlGenerator, LoggerInterface $logger = null)
    {
        $this->urlGenerator = $urlGenerator;
        $this->logger = $logger;
    }



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
    public function logout(Request $request, string $firewallName): RedirectResponse
    {


         throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');

        // mc : tentative 1 de redirection de page
//        {
//            if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
//                return new RedirectResponse($targetPath);
//            }
//
//            // For example:
//            return new RedirectResponse($this->urlGenerator->generate('app_home'));
//            //throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
//        }

        // mc : tentative 2 de redirection de page         return $this->redirectToRoute('app_home');
    }

}
