<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AgentsController extends AbstractController
{
    /**
     * @Route("/agents", name="agents")
     */
    public function index()
    {
        return $this->render('agents/index.html.twig', [
            'controller_name' => 'AgentsController',
        ]);
    }
}
