<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    /**
     * @Route("/comment/{id}", name="comment")
     */
    public function index($id)
    {
        return $this->render('comment/index.html.twig', [
            'controller_name' => $id,
        ]);
    }
}
