<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class AgentsController extends AbstractController
{
    /**
     * @Route("/agent", name="agent")
     */
    public function index()
    {
        $session = new Session(); // to work with the sessions
        $email = $session->get('email');
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $email]);

        if (isset( $_POST["claimed"])) {
            $ticket= $_POST["claimed"];
            $currentTicket = $this->getDoctrine()->getRepository(Ticket::class)->findBy(['id' =>$ticket]);
            $currentTicket= $currentTicket[0];
            $currentTicket->setAgentid($user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($currentTicket);
            $entityManager->flush();
        }

        $claimedTickets = $this->getDoctrine()->getRepository(Ticket::class) ->findBy(['agentid'=>$user->getId()]);
        $Unclaimed = $this->getDoctrine() ->getRepository(Ticket::class) ->findBy(['agentid' => null]);
        return $this->render('agents/agent.html.twig', ['allMadeTickets'=>$Unclaimed, 'agentName' => $user, 'clammed'=>$claimedTickets]);
    }
}
