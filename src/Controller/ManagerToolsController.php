<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ManagerToolsController extends AbstractController
{
    /**
     * @Route("/tools", name="manager_tools")
     */
    public function index()
    {
        return $this->render('manager_tools/tools.html.twig', [
            'controller_name' => 'ManagerToolsController',
        ]);
    }
    public function aRegister(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        // Only added these two lines
        $user->setRoles(['ROLE_AGENT_TWO']);
        $user->setTime(new \DateTime());
        // Manager has to choose to make agent one or two
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
