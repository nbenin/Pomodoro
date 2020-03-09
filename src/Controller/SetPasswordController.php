<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SetPasswordController extends AbstractController
{
    /**
     * @Route("/set/password", name="set_password")
     */
    public function index()
    {
        return $this->render('set_password/index.html.twig', [
            'controller_name' => 'SetPasswordController',
        ]);
    }
}
