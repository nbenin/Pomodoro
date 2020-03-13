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
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function addTicket(Request $request) : Response
    {

        $session = new Session(); // to work with the sessions
        $email = $session->get('email');
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $email]);
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
            $entityManager->flush(); 
        }

        $ticketInfo = $this->getDoctrine() ->getRepository(Ticket::class) ->findBy(['customerid' => $user]);
        return $this->render('customer/customer.html.twig', ['ticketForm' => $form->createView(), 'allTickets'=>$ticketInfo]);  // hoe ik aan die ticketform moet komen?]);
    }
}
