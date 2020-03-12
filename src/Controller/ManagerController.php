<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class ManagerController extends AbstractController
{
    /**
     * @Route("/manager", name="manager")
     */
    public function index()
    {
        $session = new Session(); // to work with the sessions
        $email = $session->get('email');
        $user = $this->getDoctrine()->getRepository(User::class)->findBy(['email' => $email]);
        //$user = $user[0];

        if (isset($_POST['SHUTUPNEIL'])) {
            $alltickets = $this->getDoctrine()->getRepository(Ticket::class)->findAll();
            foreach ($alltickets as $tickets)
            {
                if ($tickets->getAgentid()!== null) {
                    $tickets->setAgentid(null);

                    $empty = $this->getDoctrine()->getManager();
                    $empty->persist($tickets);
                    $empty->flush();
                }
            }


        }

        $claimedTickets = $this->getDoctrine()->getRepository(Ticket::class) ->findByNotNull();
            $ticketInfo = $this->getDoctrine() ->getRepository(Ticket::class) ->findBy(['agentid'=> null]);
        return $this->render('manager/manager.html.twig', ['allMadeTickets'=>$ticketInfo, 'managerName' => $user, 'AssTickets' => $claimedTickets ]);

    }
}
