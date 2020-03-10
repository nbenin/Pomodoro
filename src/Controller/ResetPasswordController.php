<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ResetPasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ResetPasswordController extends AbstractController
{
    /**
     * @Route("/reset", name="reset")
     */
    public function index()
    {
        return $this->render('set_password/reset.html.twig', [
            'controller_name' => 'ResetPasswordController',
        ]);
    }
}
