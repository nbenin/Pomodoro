<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ManagerToolsController extends AbstractController
{
    /**
     * @Route("/manager/tools", name="manager_tools")
     */
    public function index()
    {
        return $this->render('manager_tools/index.html.twig', [
            'controller_name' => 'ManagerToolsController',
        ]);
    }
}
