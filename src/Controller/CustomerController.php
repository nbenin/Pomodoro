<?php

namespace App\Controller;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Ticket;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\PropertyInfo\Util\PhpDocTypeHelper;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\MakeTicketForUser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class CustomerController extends AbstractController
{
    /**
     * @Route("/customer", name="customer")
     */
    public function addTicket(Request $request): Response // de functie wordt aangeroepen op het moment dat je die route doet //die request verwijst naar de post
    {
        $session = new Session(); // to work with the sessions
        $email=$session->get('email');

        $ticket = new Ticket();
        $ticket->setTime(new DateTime());

        $form = $this->createForm(MakeTicketForUser::class, $ticket);
        $form->handleRequest($request); // $request is the post

        if ($form->isSubmitted() && $form->isValid()) {
            $ticket->setStatus(1);
            $ticket->setPriority(1);
            $user=$this->getDoctrine()->getRepository(User::class)->findBy(['email'=> $email]);
            $user=$user[0];
            $ticket->setCustomerid($user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ticket);
            $entityManager->flush(); // deze code stuurt de gegevens vanuit het formulier door naar de database

        // do anything else you need here, like send an email or whatever.

            return $this->redirectToRoute('customer');
    }
        return $this->render('customer/customer.html.twig', ['ticketForm' => $form->createView(),]);  // hoe ik aan die ticketform moet komen?]);
    }
}
