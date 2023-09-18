<?php

namespace App\Controller;

use App\Entity\Event;
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

#[Route('/subscribeEvent')]
class subscribeEvent extends AbstractController {


public function subscribeToEvent (Event $event){

    new subscriptionToEvent

}}


