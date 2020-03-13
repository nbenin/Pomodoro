<?php

namespace App\Controller;

use App\Entity\Ticket;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    /**
     * @Route("/comment/{ticket}", name="comment")
     * @param Ticket $ticket
     * @return Response
     */
    public function index(Ticket $ticket)
    {


        return $this->render('comment/comment.html.twig', ["ticket" => $ticket
        ]);
    }
}
