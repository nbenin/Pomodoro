<?php

namespace App\Controller;

use App\Entity\Ticket;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
        var_dump($ticket);
        return $this->render('comment/index.html.twig', [
        ]);
    }
}
