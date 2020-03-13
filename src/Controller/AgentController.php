<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class AgentController extends AbstractController
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
            $currentTicket = $this->getDoctrine()->getRepository(Ticket::class)->findOneBy(['id' =>$ticket]);
            $currentTicket->setAgentid($user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($currentTicket);
            $entityManager->flush();
        }

        if (isset( $_POST["escalate"])) {
            $ticket= $_POST["escalate"];
            $currentTicket = $this->getDoctrine()->getRepository(Ticket::class)->findOneBy(['id' =>$ticket]);
            $currentTicket->setPriority(2); // escalate is priority 2
            $currentTicket->setAgentid(null);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($currentTicket);
            $entityManager->flush();
        }

        if (isset($_POST['closeTicket'])) {
            $ticket= $_POST["closeTicket"];
            $currentTicket = $this->getDoctrine()->getRepository(Ticket::class)->findOneBy(['id' =>$ticket]);
            $currentTicket->setStatus(3);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($currentTicket);
            $entityManager->flush();
        }

        $claimedTickets = $this->getDoctrine()->getRepository(Ticket::class) ->findBy(['agentid'=>$user->getId()]);
        $Unclaimed = $this->getDoctrine() ->getRepository(Ticket::class) ->findBy(['agentid' => null]);
        return $this->render('agents/agent.html.twig', ['allMadeTickets'=>$Unclaimed, 'agentName' => $user, 'claimed'=>$claimedTickets]);


    }
}
