<?php

namespace App\Controller;

use App\Entity\LoggerFunc;
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
        $email = $session->get('email');
        $user = $this->getDoctrine()->getRepository(User::class)->findBy(['email' => $email]);

        $ticket = new Ticket();
        $ticket->setTime(new DateTime());

        $form = $this->createForm(MakeTicketForUser::class, $ticket);
        $form->handleRequest($request); // $request is the post

        if ($form->isSubmitted() && $form->isValid()) {
            $ticket->setStatus(1);
            $ticket->setPriority(1);

            $ticket->setCustomerid($user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ticket);
            $entityManager->flush(); // deze code stuurt de gegevens vanuit het formulier door naar de database

            // do anything else you need here, like send an email or whatever.
//DELETE IF IT DOES NOTHING
            //return $this->redirectToRoute('customer');
        }

        $ticketInfo = $this->getDoctrine() ->getRepository(Ticket::class) ->findBy(['customerid' => $user]);
        return $this->render('customer/customer.html.twig', ['ticketForm' => $form->createView(), 'allTickets'=>$ticketInfo]);  // hoe ik aan die ticketform moet komen?]);
    }
}
