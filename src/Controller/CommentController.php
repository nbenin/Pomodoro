<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Entity\Message;
use App\Entity\User;
use App\Form\CommentFormType;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    /**
     * @Route("/comment/{ticket}", name="comment")
     * @param Ticket $ticket
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function index(Ticket $ticket, Request $request)
    {
        // Get logged in user from the session
        $session = $request->getSession();
        $email = $session->get('email');
        $userLogged = $this->getDoctrine()->getRepository(User::class)->findOneBy(["email" => $email]);

        // Create form for message input
        $message = new Message();
        $form = $this->createForm(CommentFormType::class, $message);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $message->setTicketid($ticket);
            $message->setUserid($userLogged);
            $message->setTime(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();
        }

        // Get all messages related to ticket and give to render
        $messageHistory = $this->getDoctrine()->getRepository(Message::class)->findBy(['ticketid' => $ticket]);
        return $this->render('comment/comment.html.twig', ["ticket" => $ticket, "messageHistory" => $messageHistory,
            "commentForm" => $form->createView(), 'user' => $userLogged
        ]);
    }
}
